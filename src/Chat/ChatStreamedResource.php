<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat;

use phpGraph\Inference\ProviderClientInterface;
use phpGraph\Inference\Chat\Request\ChatRequestInterface;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\ChatResponseInterface;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamHandlerInterface;
use Symfony\Component\HttpClient\Exception\TransportException;

readonly class ChatStreamedResource implements ChatStreamedResourceInterface
{
    /**
     * @param ProviderClientInterface $providerClient
     * @param string $endpoint
     */
    public function __construct(
        protected ProviderClientInterface $providerClient,
        protected string                  $endpoint
    )
    {
    }

    /**
     * @param ChatRequestInterface $request
     * @param ChatStreamHandlerInterface $streamHandler
     *
     * @return ChatResponseInterface|null
     */
    public function execute(ChatRequestInterface $request, ChatStreamHandlerInterface $streamHandler): ?ChatResponseInterface
    {
        try {

            $streamHandler->reset();

            $response = null;

            $stream = $this->providerClient->postStreamed($this->endpoint, [
                'json' => $request->toArray()
            ]);

            foreach ($stream as $chunk) {

                if (empty($chunkContent = trim($chunk->getContent(), PHP_EOL))) {
                    continue;
                }

                foreach (preg_split('/\r\n|\r|\n/', $chunkContent) as $line) {

                    $line = trim($line);

                    if ($line === '' || $line === '[DONE]') {
                        continue;
                    }

                    if (str_starts_with($line, 'data:')) {
                        $line = ltrim(substr($line, strlen('data:')));
                    }

                    $chunkJson = json_decode($line, true);

                    if (is_null($chunkJson)) {
                        continue;
                    }

                    $streamHandler->handle(
                        $response = new ChatResponse($chunkJson)
                    );
                }
            }

            return $response;

        } catch (\Throwable $throwable) {
            throw new TransportException(
                message: 'Inference resource chat stream failed.',
                previous: $throwable
            );
        }
    }
}
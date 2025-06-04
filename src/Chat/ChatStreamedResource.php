<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Chat;

use ArtGraph\Inference\ProviderClientInterface;
use ArtGraph\Inference\Chat\Request\ChatRequestInterface;
use ArtGraph\Inference\Chat\Response\ChatResponse;
use ArtGraph\Inference\Chat\Response\ChatResponseInterface;
use ArtGraph\Inference\Chat\Response\Stream\ChatStreamHandlerInterface;
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

                if (empty($chunkContent = $chunk->getContent())) {
                    continue;
                }

                $chunkJson = \json_decode($chunkContent, true);

                $streamHandler->handle(
                    $response = new ChatResponse($chunkJson)
                );
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
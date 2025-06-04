<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat;

use phpGraph\Inference\ProviderClientInterface;
use phpGraph\Inference\Chat\Request\ChatRequestInterface;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\ChatResponseInterface;
use Symfony\Component\HttpClient\Exception\TransportException;

readonly class ChatResource implements ChatResourceInterface
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
     *
     * @return ChatResponseInterface
     */
    public function execute(ChatRequestInterface $request): ChatResponseInterface
    {
        try {

            $response = $this->providerClient->post($this->endpoint, [
                'json' => $request->toArray()
            ]);

            return new ChatResponse($response->toArray());

        } catch (\Throwable $throwable) {
            throw new TransportException(
                message: 'Inference resource chat failed.',
                previous: $throwable
            );
        }
    }
}
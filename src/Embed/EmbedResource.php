<?php

declare(strict_types=1);

namespace phpGraph\Inference\Embed;

use phpGraph\Inference\ProviderClientInterface;
use phpGraph\Inference\Embed\Request\EmbedRequestInterface;
use phpGraph\Inference\Embed\Response\EmbedResponse;
use phpGraph\Inference\Embed\Response\EmbedResponseInterface;
use Symfony\Component\HttpClient\Exception\TransportException;

readonly class EmbedResource implements EmbedResourceInterface
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
     * @param EmbedRequestInterface $request
     *
     * @return EmbedResponseInterface
     */
    public function execute(EmbedRequestInterface $request): EmbedResponseInterface
    {
        try {

            $response = $this->providerClient->post($this->endpoint, [
                'json' => $request->toArray()
            ]);

            return new EmbedResponse($response->toArray());

        } catch (\Throwable $throwable) {
            throw new TransportException(
                message: 'Inference resource embed failed.',
                previous: $throwable
            );
        }
    }
}
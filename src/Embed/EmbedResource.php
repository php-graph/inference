<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Embed;

use ArtGraph\Inference\ProviderClientInterface;
use ArtGraph\Inference\Embed\Request\EmbedRequestInterface;
use ArtGraph\Inference\Embed\Response\EmbedResponse;
use ArtGraph\Inference\Embed\Response\EmbedResponseInterface;
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
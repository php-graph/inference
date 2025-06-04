<?php

declare(strict_types=1);

namespace phpGraph\Inference;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class ProviderClient implements ProviderClientInterface
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->httpClient = HttpClient::create($options);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function get(string $endpoint, array $parameters): ResponseInterface
    {
        return $this->httpClient->request('GET', $endpoint, $parameters);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function getStreamed(string $endpoint, array $parameters): ResponseStreamInterface
    {
        return $this->httpClient->stream($this->get($endpoint, $parameters));
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function post(string $endpoint, array $parameters): ResponseInterface
    {
        return $this->httpClient->request('POST', $endpoint, $parameters);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function postStreamed(string $endpoint, array $parameters): ResponseStreamInterface
    {
        return $this->httpClient->stream($this->post($endpoint, $parameters));
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function delete(string $endpoint, array $parameters): ResponseInterface
    {
        return $this->httpClient->request('DELETE', $endpoint, $parameters);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function deleteStreamed(string $endpoint, array $parameters): ResponseStreamInterface
    {
        return $this->httpClient->stream($this->get($endpoint, $parameters));
    }
}
<?php

declare(strict_types=1);

namespace phpGraph\Inference;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

interface ProviderClientInterface
{
    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function get(string $endpoint, array $parameters): ResponseInterface;

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function getStreamed(string $endpoint, array $parameters): ResponseStreamInterface;

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function post(string $endpoint, array $parameters): ResponseInterface;

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function postStreamed(string $endpoint, array $parameters): ResponseStreamInterface;

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function delete(string $endpoint, array $parameters): ResponseInterface;

    /**
     * @param string $endpoint
     * @param array $parameters
     *
     * @return ResponseStreamInterface
     *
     * @throws TransportExceptionInterface
     */
    public function deleteStreamed(string $endpoint, array $parameters): ResponseStreamInterface;
}
<?php

declare(strict_types=1);

namespace ArtGraph\Inference;

interface ProviderFactoryInterface
{
    /**
     * @param string $host
     *
     * @return ProviderResourceInterface
     */
    public static function createOllamaResource(#[\SensitiveParameter] string $host): ProviderResourceInterface;

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createOpenAiResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface;

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createMistralResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface;

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createDeepSeekResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface;
}
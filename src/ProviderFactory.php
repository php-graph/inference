<?php

declare(strict_types=1);

namespace phpGraph\Inference;

use phpGraph\Inference\Chat\ChatResource;
use phpGraph\Inference\Chat\ChatStreamedResource;
use phpGraph\Inference\Embed\EmbedResource;
use Symfony\Component\HttpClient\HttpOptions;

class ProviderFactory implements ProviderFactoryInterface
{
    /**
     * @param string $host
     *
     * @return ProviderResourceInterface
     */
    public static function createOllamaResource(#[\SensitiveParameter] string $host): ProviderResourceInterface
    {
        $httpClient = new ProviderClient(
            (new HttpOptions())
                ->setBaseUri($host)
                ->toArray()
        );

        return new ProviderResource(
            name: 'ollama',
            chatResource: new ChatResource($httpClient, '/api/chat'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/api/chat'),
            embedResource: new EmbedResource($httpClient, '/api/embed'),
        );
    }

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createOpenAiResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface
    {
        $httpClient = new ProviderClient(
            (new HttpOptions())
                ->setBaseUri('https://api.openai.com/v1/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            name: 'open-ai',
            chatResource: new ChatResource($httpClient, '/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/embeddings'),
        );
    }

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createMistralResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface
    {
        $httpClient = new ProviderClient(
            (new HttpOptions())
                ->setBaseUri('https://api.mistral.ai/v1/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            name: 'mistral',
            chatResource: new ChatResource($httpClient, '/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/embeddings'),
        );
    }

    /**
     * @param string $apiKey
     *
     * @return ProviderResourceInterface
     */
    public static function createDeepSeekResource(#[\SensitiveParameter] string $apiKey): ProviderResourceInterface
    {
        $httpClient = new ProviderClient(
            (new HttpOptions())
                ->setBaseUri('https://api.deepseek.com/v1/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            name: 'deep-seek',
            chatResource: new ChatResource($httpClient, '/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/embeddings'),
        );
    }
}
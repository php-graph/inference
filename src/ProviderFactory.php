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
                ->setBaseUri('https://api.openai.com/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            chatResource: new ChatResource($httpClient, '/v1/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/v1/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/v1/embeddings'),
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
                ->setBaseUri('https://api.mistral.ai/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            chatResource: new ChatResource($httpClient, '/v1/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/v1/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/v1/embeddings'),
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
                ->setBaseUri('https://api.deepseek.com/')
                ->setAuthBearer($apiKey)
                ->toArray()
        );

        return new ProviderResource(
            chatResource: new ChatResource($httpClient, '/v1/chat/completions'),
            chatStreamedResource: new ChatStreamedResource($httpClient, '/v1/chat/completions'),
            embedResource: new EmbedResource($httpClient, '/v1/embeddings'),
        );
    }
}
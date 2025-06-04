<?php

declare(strict_types=1);

namespace phpGraph\Inference;

use phpGraph\Inference\Chat\ChatResourceInterface;
use phpGraph\Inference\Chat\ChatStreamedResourceInterface;
use phpGraph\Inference\Embed\EmbedResourceInterface;

readonly class ProviderResource implements ProviderResourceInterface
{
    /**
     * @param string $name
     * @param ChatResourceInterface $chatResource
     * @param ChatStreamedResourceInterface $chatStreamedResource
     * @param EmbedResourceInterface $embedResource
     */
    public function __construct(
        private string                              $name,
        private ChatResourceInterface               $chatResource,
        private ChatStreamedResourceInterface       $chatStreamedResource,
        private EmbedResourceInterface              $embedResource,
    )
    {
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return ChatResourceInterface
     */
    public function chat(): ChatResourceInterface
    {
        return $this->chatResource;
    }

    /**
     * @return ChatStreamedResourceInterface
     */
    public function chatStreamed(): ChatStreamedResourceInterface
    {
        return $this->chatStreamedResource;
    }

    /**
     * @return EmbedResourceInterface
     */
    public function embed(): EmbedResourceInterface
    {
        return $this->embedResource;
    }
}
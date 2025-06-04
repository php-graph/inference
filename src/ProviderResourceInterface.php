<?php

declare(strict_types=1);

namespace ArtGraph\Inference;

use ArtGraph\Inference\Chat\ChatResourceInterface;
use ArtGraph\Inference\Chat\ChatStreamedResourceInterface;
use ArtGraph\Inference\Embed\EmbedResourceInterface;

interface ProviderResourceInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return ChatResourceInterface
     */
    public function chat(): ChatResourceInterface;

    /**
     * @return ChatStreamedResourceInterface
     */
    public function chatStreamed(): ChatStreamedResourceInterface;

    /**
     * @return EmbedResourceInterface
     */
    public function embed(): EmbedResourceInterface;
}
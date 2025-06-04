<?php

declare(strict_types=1);

namespace phpGraph\Inference;

use phpGraph\Inference\Chat\ChatResourceInterface;
use phpGraph\Inference\Chat\ChatStreamedResourceInterface;
use phpGraph\Inference\Embed\EmbedResourceInterface;

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
<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Chat;

use ArtGraph\Inference\Chat\Request\ChatRequestInterface;
use ArtGraph\Inference\Chat\Response\ChatResponseInterface;

interface ChatResourceInterface
{
    /**
     * @param ChatRequestInterface $request
     *
     * @return ChatResponseInterface
     */
    public function execute(ChatRequestInterface $request): ChatResponseInterface;
}
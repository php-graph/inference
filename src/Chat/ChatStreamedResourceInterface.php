<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Chat;

use ArtGraph\Inference\Chat\Request\ChatRequestInterface;
use ArtGraph\Inference\Chat\Response\ChatResponseInterface;
use ArtGraph\Inference\Chat\Response\Stream\ChatStreamHandlerInterface;

interface ChatStreamedResourceInterface
{
    /**
     * @param ChatRequestInterface $request
     * @param ChatStreamHandlerInterface $streamHandler
     *
     * @return ChatResponseInterface|null
     */
    public function execute(ChatRequestInterface $request, ChatStreamHandlerInterface $streamHandler): ?ChatResponseInterface;
}
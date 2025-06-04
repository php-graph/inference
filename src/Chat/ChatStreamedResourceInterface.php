<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat;

use phpGraph\Inference\Chat\Request\ChatRequestInterface;
use phpGraph\Inference\Chat\Response\ChatResponseInterface;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamHandlerInterface;

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
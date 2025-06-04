<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat;

use phpGraph\Inference\Chat\Request\ChatRequestInterface;
use phpGraph\Inference\Chat\Response\ChatResponseInterface;

interface ChatResourceInterface
{
    /**
     * @param ChatRequestInterface $request
     *
     * @return ChatResponseInterface
     */
    public function execute(ChatRequestInterface $request): ChatResponseInterface;
}
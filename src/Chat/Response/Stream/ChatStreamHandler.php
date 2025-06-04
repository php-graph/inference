<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat\Response\Stream;

use phpGraph\Inference\Chat\Response\ChatResponseInterface;

class ChatStreamHandler implements ChatStreamHandlerInterface
{
    /**
     * @var iterable
     */
    private iterable $handlers;

    /**
     * @param iterable $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        foreach ($this->handlers as $handler) {
            $handler->reset();
        }
    }

    /**
     * @param ChatResponseInterface $chatResponse
     *
     * @return void
     */
    public function handle(ChatResponseInterface $chatResponse): void
    {
        foreach ($this->handlers as $handler) {
            $handler->handle($chatResponse);
        }
    }
}
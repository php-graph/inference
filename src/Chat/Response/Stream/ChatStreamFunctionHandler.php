<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat\Response\Stream;

use phpGraph\Inference\Chat\Response\ChatResponseInterface;

class ChatStreamFunctionHandler implements ChatStreamFunctionHandlerInterface, ChatStreamHandlerInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var string
     */
    protected string $content = '';

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->content = '';
    }

    /**
     * @param ChatResponseInterface $chatResponse
     *
     * @return void
     */
    public function handle(ChatResponseInterface $chatResponse): void
    {
        $this->content .= call_user_func($this->callback, $chatResponse);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
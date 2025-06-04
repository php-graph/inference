<?php

declare(strict_types=1);

namespace phpGraph\Inference\Chat\Response\Stream;

use phpGraph\Inference\Chat\Response\ChatResponseInterface;
use Symfony\Contracts\Service\ResetInterface;

interface ChatStreamHandlerInterface extends ResetInterface
{
    /**
     * @return void
     */
    public function reset(): void;

    /**
     * @param ChatResponseInterface $chatResponse
     *
     * @return void
     */
    public function handle(ChatResponseInterface $chatResponse): void;
}
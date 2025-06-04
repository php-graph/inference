<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Chat\Response\Stream;

use ArtGraph\Inference\Chat\Response\ChatResponseInterface;
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
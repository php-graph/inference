<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Chat\Response\Stream;

interface ChatStreamFunctionHandlerInterface
{
    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): static;
}
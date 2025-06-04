<?php

declare(strict_types=1);

namespace phpGraph\Inference\Embed;

use phpGraph\Inference\Embed\Request\EmbedRequestInterface;
use phpGraph\Inference\Embed\Response\EmbedResponseInterface;

interface EmbedResourceInterface
{
    /**
     * @param EmbedRequestInterface $request
     *
     * @return EmbedResponseInterface
     */
    public function execute(EmbedRequestInterface $request): EmbedResponseInterface;
}
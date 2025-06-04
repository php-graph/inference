<?php

declare(strict_types=1);

namespace ArtGraph\Inference\Embed;

use ArtGraph\Inference\Embed\Request\EmbedRequestInterface;
use ArtGraph\Inference\Embed\Response\EmbedResponseInterface;

interface EmbedResourceInterface
{
    /**
     * @param EmbedRequestInterface $request
     *
     * @return EmbedResponseInterface
     */
    public function execute(EmbedRequestInterface $request): EmbedResponseInterface;
}
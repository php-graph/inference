<?php

declare(strict_types=1);

namespace phpGraph\Inference\DependencyInjection;

use phpGraph\Inference\Command\InferenceChatCommand;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class InferencePass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition(InferenceChatCommand::class)) {

            $definition = $container->getDefinition(InferenceChatCommand::class);

            $definition->addTag('console.command');
        }
    }
}
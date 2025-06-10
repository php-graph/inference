<?php

declare(strict_types=1);

namespace phpGraph\Inference\Command;

use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;
use phpGraph\Inference\ProviderFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'inference:chat',)]
class InferenceChatCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ollamaHost = $io->ask('Ollama host:');

        $ollamaChat = ProviderFactory::createOllamaResource($ollamaHost);

        while (true) {

            $message = $io->ask('message: ');

            if ($message === '/bye') {
                break;
            }

            $messages = [[
                'role'      => 'system',
                'content'   => 'You are an intelligent AI agent named Symfony.'
            ]];

            $ollamaRequest = new ChatRequest([
                'model'     => 'devstral',
                'messages'  => $messages,
                'stream'    => true,
            ]);

            $ollamaStreamHandler = new ChatStreamFunctionHandler(
                function (ChatResponse $chatResponse) use ($output) {
                    $output->write($chatResponse->get('message')['content'] ?? '');
                }
            );

            $ollamaChat->chatStreamed()->execute($ollamaRequest, $ollamaStreamHandler);

            $messages[] = [
                'role'      => 'assistant',
                'content'   => $ollamaStreamHandler->getContent(),
            ];

            $output->writeln('');
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}
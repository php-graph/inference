![phpGraph Banner.](/static/banner.png)

# Inference

This project is a PHP component designed to simplify the integration and usage of Large Language Models (LLMs) from various providers, including Ollama, OpenAI, Mistral, DeepSeek, and more.
It offers a unified interface for:

* Interacting with chat models (standard completions, streaming, etc.)
* Generating vector embeddings
* Managing multi-provider compatibility without altering your application logic

The goal is to provide a simple, extensible, and developer-oriented abstraction for AI inference, enabling optimal performance and rapid integration into your PHP projects.

## Get Started

First, install phpGraph Inference via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require php-graph/inference
```

## Usages

### Ollama

#### Chat

> The following example demonstrates how to use Ollama as a local LLM provider for a standard chat interaction. You instantiate a resource, build your message history, and get the assistant's response.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;

$resource = ProviderFactory::createOllamaResource('http://localhost:11434/');

$request = new ChatRequest([
    'model' => 'devstral',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => false,
]);

$response = $resource->chat()->execute($request);

echo $response->toArray()['message']['content'];
```

#### Chat Stream

> To stream the response token-by-token (useful for chat UIs and progress feedback), instantiate the resource with `chatStreamed()` and provide a handler that processes each chunk as it arrives.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;

$resource = ProviderFactory::createOllamaResource('http://localhost:11434/');

$request = new ChatRequest([
    'model' => 'devstral',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => true,
]);

$streamHandler = new ChatStreamFunctionHandler(
    function (ChatResponse $response) {
        echo $response->toArray()['message']['content'];
    }
);

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

> To generate vector embeddings with Ollama, simply use the `embed()` method on the resource and pass your text or batch of texts. The returned array contains the embedding vector(s).

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Embed\Request\EmbedRequest;

$resource = ProviderFactory::createOllamaResource('http://localhost:11434/');

$request = new EmbedRequest([
    'model'     => 'nomic-embed-text',
    'prompt'    => 'This is a test sentence for embedding.',
    ],
]);

echo $resource->embed()->execute($request)->toArray()['embedding'];
```

---

### OpenAI

#### Chat

> For OpenAI's GPT models, the usage is nearly identical. After configuring your API key and provider, send your conversation history and extract the assistant's response from the returned structure.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;

$apiKey = getenv('OPENAI_API_KEY');

$resource = ProviderFactory::createOpenAiResource($apiKey);

$request = new ChatRequest([
    'model' => 'gpt-4o',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => false,
]);

$response = $resource->chat()->execute($request);

echo $response->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

> OpenAI also supports streaming chat completions. Use the streaming resource and provide a handler that is called for each streamed content delta.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;

$apiKey = getenv('OPENAI_API_KEY');

$resource = ProviderFactory::createOpenAiResource($apiKey);

$request = new ChatRequest([
    'model' => 'gpt-4o',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => true,
]);

$streamHandler = new ChatStreamFunctionHandler(
    function (ChatResponse $response) {
        echo $response->toArray()['choices'][0]['delta']['content'];
    }
);

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

> To get high-quality embeddings from OpenAI, specify the embedding model and input texts. The response contains an array of embeddings matching the input order.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Embed\Request\EmbedRequest;

$apiKey = getenv('OPENAI_API_KEY');

$resource = ProviderFactory::createOpenAiResource($apiKey);

$request = new EmbedRequest([
    'model' => 'text-embedding-3-small',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
]);

echo $resource->embed()->execute($request)->toArray();
```

---

### Mistral

#### Chat

> Mistral provides OpenAI-compatible chat endpoints. Simply use your API key and the right model. The format and usage remain consistent with the other providers.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;

$apiKey = getenv('MISTRAL_API_KEY');

$resource = ProviderFactory::createMistralResource($apiKey);

$request = new ChatRequest([
    'model' => 'mistral-large-latest',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => false,
]);

$response = $resource->chat()->execute($request);

echo $response->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

> Streaming responses are supported just like with OpenAI, making it easy to plug into chat UIs or progressive LLM pipelines.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;

$apiKey = getenv('MISTRAL_API_KEY');

$resource = ProviderFactory::createMistralResource($apiKey);

$request = new ChatRequest([
    'model' => 'mistral-large-latest',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => true,
]);

$streamHandler = new ChatStreamFunctionHandler(
    function (ChatResponse $response) {
        echo $response->toArray()['choices'][0]['delta']['content'];
    }
);

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

> For embeddings, use the appropriate Mistral model. The structure of the response is similar to OpenAI's, with each embedding in the `data` array.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Embed\Request\EmbedRequest;

$apiKey = getenv('MISTRAL_API_KEY');

$resource = ProviderFactory::createMistralResource($apiKey);

$request = new EmbedRequest([
    'model' => 'mistral-embed',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
]);

echo $resource->embed()->execute($request)->toArray();
```

---

### DeepSeek

#### Chat

> DeepSeek also exposes an OpenAI-compatible API. You can interact with it in the same way, making switching providers simple.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;

$apiKey = getenv('DEEPSEEK_API_KEY');

$resource = ProviderFactory::createDeepSeekResource($apiKey);

$request = new ChatRequest([
    'model' => 'deepseek-chat',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => false,
]);

$response = $resource->chat()->execute($request);

echo $response->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

> Streaming works identically: use the streamed resource and process each chunk via your handler.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;

$apiKey = getenv('DEEPSEEK_API_KEY');

$resource = ProviderFactory::createDeepSeekResource($apiKey);

$request = new ChatRequest([
    'model' => 'deepseek-chat',
    'messages' => [
        [
            'role'      => 'user', 
            'content'   => 'why is the sky blue?'
        ],
        [
            'role'      => 'assistant',
            'content'   => 'due to rayleigh scattering.'
        ],
        [
            'role'      => 'user',
            'content'   => 'how is that different than mie scattering?'
        ],
    ],
    'stream' => true,
]);

$streamHandler = new ChatStreamFunctionHandler(
    function (ChatResponse $response) {
        echo $response->toArray()['choices'][0]['delta']['content'];
    }
);

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

> DeepSeek embeddings are retrieved with the same API contract. Specify the embedding model and input; parse the embeddings from the `data` array in the response.

```php
<?php

use phpGraph\Inference\ProviderFactory;
use phpGraph\Inference\Embed\Request\EmbedRequest;

$apiKey = getenv('DEEPSEEK_API_KEY');

$resource = ProviderFactory::createDeepSeekResource($apiKey);

$request = new EmbedRequest([
    'model' => 'deepseek-embedding',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
]);

echo $resource->embed()->execute($request)->toArray();
```

## Example : 

#### Symfony Command

```php
<?php

declare(strict_types=1);

namespace App\Command;

use phpGraph\Inference\Chat\Request\ChatRequest;
use phpGraph\Inference\Chat\Response\ChatResponse;
use phpGraph\Inference\Chat\Response\Stream\ChatStreamFunctionHandler;
use phpGraph\Inference\ProviderFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'inference:chat')]
class InferenceChatCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ollamaResource = ProviderFactory::createOllamaResource('http://localhost:11434');
        
        $ollamaModel = 'mistral-small3.1';

        $messages = $baseMessage = [[
            'role'      => 'system',
            'content'   => 'You are an intelligent AI agent named Symfony.'
        ]];

        $tools = [
            [
                'type' => 'function',
                'function' => [
                    'name'          => 'currentDateTime',
                    'description'   => 'Provides the UTC date and time in Y-m-d H:i:s format',
                ],
            ],
        ];

        $options = [
            'temperature' => 0,
        ];

        while (true) {

            $message = $io->ask('message');

            if ($message === '/bye') {
                break;
            }

            if ($message === '/reset') {

                $messages = $baseMessage;

                continue;
            }

            $messages[] = [
                'role'      => 'user',
                'content'   => $message,
            ];

            reload:

            $ollamaRequest = new ChatRequest([
                'model'     => $ollamaModel,
                'messages'  => $messages,
                'tools'     => $tools,
                'options'   => $options,
                'stream'    => true,
            ]);

            $hasTools = false;

            $ollamaStreamHandler = new ChatStreamFunctionHandler(
                function (ChatResponse $chatResponse) use ($output, &$messages, &$hasTools) {

                    $message = $chatResponse->get('message');

                    if (isset($message['tool_calls'])) {

                        foreach ($message['tool_calls'] as $tool) {

                            $name = $tool['function']['name'];

                            $arguments = $tool['function']['arguments'];
                            
                            $content = call_user_func_array([$this, $name], $arguments);

                            $messages[] = [
                                'role'      => 'tool',
                                'content'   => $content,
                            ];
                        }

                        $hasTools = true;
                    }

                    $content = $message['content'] ?? '';

                    $output->write($content);

                    return $content;
                }
            );

            $ollamaResource->chatStreamed()->execute($ollamaRequest, $ollamaStreamHandler);

            if ($hasTools) {
                goto reload;
            }

            $messages[] = [
                'role'      => 'assistant',
                'content'   => $ollamaStreamHandler->getContent(),
            ];

            $messages = array_slice($messages, -50, 50);

            $output->writeln('');
            $output->writeln('');
        }

        return Command::SUCCESS;
    }

    /**
     * @return string
     */
    public function currentDateTime(): string
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }
}
```

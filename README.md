![phpGraph Banner.](/docs/banner.png)

# Inference

## Get Started

---

First, install phpGraph Inference via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require phpgraph/inference
```

## Usages

---

### Ollama

#### Chat

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

echo $resource->chat()->execute($request)->toArray()['message']['content'];
```

#### Chat Stream

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
)

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

```php
<?php

use phpGraph\Inference\ProviderFactory;

$resource = ProviderFactory::createOllamaResource('http://localhost:11434/');

$request = [
    'model'     => 'nomic-embed-text',
    'prompt'    => 'This is a test sentence for embedding.',
];

echo $resource->embed()->execute($request)->toArray()['embedding'];
```

---

### OpenAI

#### Chat

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

echo $resource->chat()->execute($request)->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

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
)

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

```php
<?php

use phpGraph\Inference\ProviderFactory;

$apiKey = getenv('OPENAI_API_KEY');

$resource = ProviderFactory::createOpenAiResource($apiKey);

$request = [
    'model' => 'text-embedding-3-small',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
];

echo $resource->embed()->execute($request)->toArray();
```

---

### Mistral

#### Chat

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

echo $resource->chat()->execute($request)->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

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
)

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

```php
<?php

use phpGraph\Inference\ProviderFactory;

$apiKey = getenv('MISTRAL_API_KEY');

$resource = ProviderFactory::createMistralResource($apiKey);

$request = [
    'model' => 'mistral-embed',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
];

echo $resource->embed()->execute($request)->toArray();
```

---

### DeepSeek

#### Chat

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

echo $resource->chat()->execute($request)->toArray()['choices'][0]['message']['content'];
```

#### Chat Stream

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
)

$resource->chatStreamed()->execute($request, $streamHandler);
```

#### Embeddings

```php
<?php

use phpGraph\Inference\ProviderFactory;

$apiKey = getenv('DEEPSEEK_API_KEY');

$resource = ProviderFactory::createDeepSeekResource($apiKey);

$request = [
    'model' => 'deepseek-embedding',
    'input' => [
        'This is a test sentence for embedding.',
        'Another sentence to embed.'
    ],
];

echo $resource->embed()->execute($request)->toArray();
```

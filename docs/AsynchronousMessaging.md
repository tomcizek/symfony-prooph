# AsynchronousMessaging

<p>
    If you want integrate prooph with some asynchronous messaging library
    of your choice (for example RabbitMq),
    you need to write whole implementation of `Prooph\ServiceBus\Async\MessageProducer` on your own. 
    And you need to make it so that you can configure what message to what producer/exchange should go, right?
    But hang on boy.
</p>

## This package is shipped with configurable MessageProducer
<p>
    Implemented with 
    `TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducer`,
    to make it little bit easier for you. It is automatically 
    registered in Nette container with special id for each bus (if you provide 
    special config for it).
</p>

<p>
    In this config (example for asynchronous events configuration):
</p>

```yaml
prooph:
    asynchronous_messaging:
        events:
            bridge: 'producerBridge'
            routes:
                TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated: producerRouteKey
```

<p>
    you set your routes and type/id of your service that implements bridge interface 
    (`TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducerBridge`)
    (Yes, damn, you still have to implement something but I will show you, it's easy!).
</p>

<p>
    This will register service `TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducer` 
    with container id "prooph.asynchronous_messaging.events".
</p>

<p>
    To make it work, you need to have registered your implementation of 
    `TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducerBridge` 
    with ID you provided in asynchronous_messaging config (you can have it type based).
</p>
</ol>

For example:

```yaml
services:
    producerBridge: 
        class: TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge
```

<br>

Then, you can set async_switch router at Command, Event and/or Query bus configuration with
that special id. To stick to our example:
```yaml
prooph:
    service_bus:
        event_bus:
            router:
                async_switch: 'prooph.asynchronous_messaging.events'
```

## Final working example config might be:

```yaml
prooph:
    asynchronous_messaging:
        events:
            bridge: "producerBridge"
            routes:
                TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated: producerRouteKey
    service_bus:
        event_bus:
            router:
                async_switch: "prooph.asynchronous_messaging.events"
                
services:
    producerBridge: 
        class: TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge
        
    Prooph\Common\Messaging\FQCNMessageFactory:
```

<p>
    Now, your messages emmited from bus will go through your implementation of bridge you set.
</p>

<p>
    Note: messages are routed based on message-name parameter, not class name! 
    It's just that by default message-name parameter equals message class name.
</p>

<br>

## Example `AsynchronousMessageProducerBridge` implementation
<p>
    Implementing `TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducerBridge` is very easy,
    it has just one method: 
</p>

```php
<?php

namespace TomCizek\SymfonyProoph\AsynchronousMessages;

interface AsynchronousMessageProducerBridge
{

    public function publishWithRoutingKey(Message $message, string $routingKey): void;
}
```

<p>
    So in case of RabbitMQ, for example, it can be implemented as easy as:
</p>


```php
<?php

namespace Example\Infrastructure;

use DateTime;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\MessageConverter;
use Prooph\Common\Messaging\MessageDataAssertion;
use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducerBridge;

class AsynchronousMessageProducer implements AsynchronousMessageProducerBridge
{

	/** @var Producer */
	private $producer;

	/** @var MessageConverter */
	private $messageConverter;

	public function __construct(Producer $producer, MessageConverter $messageConverter)
	{
		$this->producer = $producer;
		$this->messageConverter = $messageConverter;
	}
	
	public function publishWithRoutingKey(Message $message, string $routingKey): void
	{
		// converting message to string is something you implement yourself however you need
		$stringMessage = $this->convertMessageToString($mesage);
		$this->producer->publish($stringMessage, $routingKey);
	}

	private function convertMessageToString(Message $message): string
	{
		$messageData = $this->messageConverter->convertToArray($message);
		MessageDataAssertion::assert($messageData);
		$messageData['created_at'] = $message->createdAt()->format(DateTime::ATOM);

		return json_encode($messageData);
	}
}

```

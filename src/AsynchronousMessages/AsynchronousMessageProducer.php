<?php

namespace TomCizek\SymfonyProoph\AsynchronousMessages;

use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\MessageConverter;
use Prooph\ServiceBus\Async\MessageProducer;
use Prooph\ServiceBus\Exception\RuntimeException;
use React\Promise\Deferred;

class AsynchronousMessageProducer implements MessageProducer
{
	/* @var AsynchronousMessageProducerBridge */
	private $producerBridge;

	/** @var MessageConverter */
	private $messageConverter;

	/** @var array */
	private $routes;

	public function __construct(AsynchronousMessageProducerBridge $producerBridge, MessageConverter $messageConverter)
	{
		$this->producerBridge = $producerBridge;
		$this->messageConverter = $messageConverter;
	}

	public function injectRoutes(array $routes)
	{
		$this->routes = $routes;
	}

	public function __invoke(Message $message, Deferred $deferred = null): void
	{
		if ($deferred !== null) {
			throw new RuntimeException(__CLASS__ . ' cannot handle query messages which require future responses.');
		}

		$routingKey = $this->getRoutingKeyFromMessageRoute($message);

		$this->producerBridge->publishWithRoutingKey($message, $routingKey);
	}

	private function getRoutingKeyFromMessageRoute(Message $message): string
	{
		if (empty($this->routes[$message->messageName()])) {
			throw new RuntimeException(
				sprintf(
					'Producer route key for message of name "%s" in asynchronous routing not found.',
					$message->messageName()
				)
			);
		}

		return $this->routes[$message->messageName()];
	}
}

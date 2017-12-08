<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations;

use Prooph\Common\Messaging\Message;
use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducerBridge;

class TestAsynchronousMessageProducerBridge implements AsynchronousMessageProducerBridge
{
	public const KEY_ROUTING_KEY = 'routingKey';
	public const KEY_MESSAGE = 'message';

	private $published = [];

	public function publishWithRoutingKey(Message $message, string $routingKey): void
	{
		$this->published[] = [
			self::KEY_ROUTING_KEY => $routingKey,
			self::KEY_MESSAGE => $message,
		];
	}

	public function getPublished()
	{
		return $this->published;
	}
}

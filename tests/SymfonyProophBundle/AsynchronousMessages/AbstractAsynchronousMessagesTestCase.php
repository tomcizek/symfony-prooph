<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

use Prooph\Common\Messaging\Message;
use TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated;

abstract class AbstractAsynchronousMessagesTestCase extends ProophTestCase
{
	protected function thenShouldPublishExpectedMessageToExpectedProducerRouteKey($expectedProducerRouteKey): void
	{
		$publishedMessagesDump = $this->getPublishedEventsFromTestBridge();

		self::assertCount(1, $publishedMessagesDump);
		$publishedProducerRouteKey = $publishedMessagesDump[0][TestAsynchronousMessageProducerBridge::KEY_ROUTING_KEY];
		/** @var Message $publishedMessage */
		$publishedMessage = $publishedMessagesDump[0][TestAsynchronousMessageProducerBridge::KEY_MESSAGE];
		self::assertEquals($publishedProducerRouteKey, $expectedProducerRouteKey);
		self::assertEquals($publishedMessage->messageName(), TestAggregateCreated::class);
		self::assertEquals($publishedMessage->payload(), TestAggregateCreated::TEST_PAYLOAD);
	}

	abstract protected function getPublishedEventsFromTestBridge(): array;
}

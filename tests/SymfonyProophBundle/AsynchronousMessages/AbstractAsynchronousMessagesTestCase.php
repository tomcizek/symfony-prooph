<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

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
		$publishedMessageData = $publishedMessagesDump[0][TestAsynchronousMessageProducerBridge::KEY_DATA];
		self::assertEquals($publishedProducerRouteKey, $expectedProducerRouteKey);
		self::assertEquals($publishedMessageData['message_name'], TestAggregateCreated::class);
		self::assertEquals($publishedMessageData['payload'], TestAggregateCreated::TEST_PAYLOAD);
	}

	abstract protected function getPublishedEventsFromTestBridge(): array;
}

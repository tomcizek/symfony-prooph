<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

use TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\MemoryTestRepository;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\TestAggregateRoot;

class AsynchronousMessagesExampleIntegrationTest extends AbstractAsynchronousMessagesTestCase
{
	const FIXTURE_CONFIG_FILE = 'FullTestConfig.yml';
	const TEST_PRODUCER_ROUTE_KEY = 'producerRouteKey';

	public function testInvoke_WithTestConfig_BySavingNewAggregateToRepostory_ShouldPublishExpectedMessageToExpectedProducerRouteKey(
	)
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$repository = $this->givenTestRepository();
		$aggregate = $this->givenTestAggregate();

		$this->whenAggregateSaved($repository, $aggregate);

		$this->thenShouldPublishExpectedMessageToExpectedProducerRouteKey(self::TEST_PRODUCER_ROUTE_KEY);
	}

	private function givenTestRepository(): MemoryTestRepository
	{
		/** @var MemoryTestRepository $repository */
		$repository = $this->container->get(MemoryTestRepository::class);

		return $repository;
	}

	private function givenTestAggregate(): TestAggregateRoot
	{
		return TestAggregateRoot::create();
	}

	private function whenAggregateSaved(MemoryTestRepository $repository, TestAggregateRoot $aggregate): void
	{
		$repository->save($aggregate);
	}

	protected function getPublishedEventsFromTestBridge(): array
	{
		/** @var TestAsynchronousMessageProducerBridge $testProducerBridge */
		$testProducerBridge = $this->container->get(TestAsynchronousMessageProducerBridge::class);

		return $testProducerBridge->getPublished();
	}
}

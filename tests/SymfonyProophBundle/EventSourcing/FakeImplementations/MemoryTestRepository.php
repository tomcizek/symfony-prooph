<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventStore\TransactionalActionEventEmitterEventStore;
use Ramsey\Uuid\UuidInterface;

class MemoryTestRepository extends AggregateRepository implements MemoryTestRepositoryInterface
{
	/**
	 * @var TransactionalActionEventEmitterEventStore
	 */
	protected $eventStore;

	public function save(TestAggregateRoot $testAggregateRoot): void
	{
		$this->eventStore->beginTransaction();
		$this->saveAggregateRoot($testAggregateRoot);
		$this->eventStore->commit();
	}

	public function load(UuidInterface $uuid): TestAggregateRoot
	{
		/** @var TestAggregateRoot $testAggregateRoot */
		$testAggregateRoot = $this->getAggregateRoot($uuid->toString());

		return $testAggregateRoot;
	}
}


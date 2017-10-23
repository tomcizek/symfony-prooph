<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\EventSourcing;

use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\MemoryTestRepository;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\MemoryTestRepositoryInterface;

class EventSourcingConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'EventSourcingConfiguratorTest.yml';

	public function testGetRepositoryByServiceId_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$repository = $this->whenGetFromContainer('prooph.event_sourcing.test_repository');

		$this->thenIsInstanceOfGivenClass(MemoryTestRepository::class, $repository);
	}

	public function testGetRepositoryByClassName_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$repository = $this->whenGetFromContainer(MemoryTestRepository::class);

		$this->thenIsInstanceOfGivenClass(MemoryTestRepository::class, $repository);
	}

	public function testGetRepositoryByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$repository = $this->whenGetFromContainer(MemoryTestRepositoryInterface::class);

		$this->thenIsInstanceOfGivenClass(MemoryTestRepository::class, $repository);
		$this->thenIsInstanceOfGivenClass(MemoryTestRepositoryInterface::class, $repository);
	}
}

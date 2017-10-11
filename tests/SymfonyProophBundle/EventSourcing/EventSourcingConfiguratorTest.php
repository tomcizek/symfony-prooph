<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\EventSourcing;

use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\MemoryTestRepository;

class EventSourcingConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'EventSourcingConfiguratorTest.yml';

	public function testGetRepositoryByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$repository = $this->whenGetFromContainer('prooph.test_repository');

		$this->thenIsInstanceOfGivenClass(MemoryTestRepository::class, $repository);
	}
}

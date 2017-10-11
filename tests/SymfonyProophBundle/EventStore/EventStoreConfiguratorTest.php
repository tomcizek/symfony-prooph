<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\EventStore;

use Prooph\EventStore\EventStore;
use TomCizek\SymfonyProoph\BadConfigurationException;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class EventStoreConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'EventStoreConfiguratorTest.yml';
	private const FIXTURE_CONFIG_FILE_WITHOUT_FACTORY = 'Invalid/EventStoreConfiguratorWithoutFactoryTest.yml';

	public function testGetEventStoreByName_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$eventStoreService = $this->whenGetFromContainer('prooph.event_store.default');

		$this->thenIsInstanceOfGivenClass(EventStore::class, $eventStoreService);
	}

	public function testGetEventStoreByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$eventStoreService = $this->whenGetFromContainer(EventStore::class);

		$this->thenIsInstanceOfGivenClass(EventStore::class, $eventStoreService);
	}

	public function testBootKernel_WithConfigWithoutEventStoreFactory_ShouldThrowBadConfigurationException()
	{
		$this->willThrowException(BadConfigurationException::class);

		$this->whenBootKernelWithConfig(self::FIXTURE_CONFIG_FILE_WITHOUT_FACTORY);
	}
}

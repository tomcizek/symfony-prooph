<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\ServiceBus\Configurators\ServiceBusConfigurators;

use Prooph\ServiceBus\EventBus;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class EventBusConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'ServiceBusConfiguratorTests/CommandBusConfiguratorTest.yml';

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$bus = $this->whenGetFromContainer(EventBus::class);

		$this->thenIsInstanceOfGivenClass(EventBus::class, $bus);
	}
}

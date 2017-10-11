<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\ServiceBus\ServiceBusConfigurators;

use Prooph\ServiceBus\CommandBus;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class CommandBusConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'ServiceBusConfiguratorTests/CommandBusConfiguratorTest.yml';

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$bus = $this->whenGetFromContainer(CommandBus::class);

		$this->thenIsInstanceOfGivenClass(CommandBus::class, $bus);
	}
}

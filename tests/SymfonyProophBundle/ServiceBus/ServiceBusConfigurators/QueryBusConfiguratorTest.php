<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\ServiceBus\Configurators\ServiceBusConfigurators;

use Prooph\ServiceBus\QueryBus;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class QueryBusConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'ServiceBusConfiguratorTests/QueryBusConfiguratorTest.yml';

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$bus = $this->whenGetFromContainer(QueryBus::class);

		$this->thenIsInstanceOfGivenClass(QueryBus::class, $bus);
	}
}

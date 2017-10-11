<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\ServiceBus;

use TomCizek\SymfonyProoph\Common\CompositeConfigurator;
use TomCizek\SymfonyProoph\Common\Configurator;
use TomCizek\SymfonyProoph\ServiceBus\ServiceBusConfigurators\CommandBusConfigurator;
use TomCizek\SymfonyProoph\ServiceBus\ServiceBusConfigurators\EventBusConfigurator;
use TomCizek\SymfonyProoph\ServiceBus\ServiceBusConfigurators\QueryBusConfigurator;

class ServiceBusesConfigurator extends CompositeConfigurator
{
	public const KEY_SERVICE_BUS = 'service_bus';

	public function getConfigKey(): string
	{
		return self::KEY_SERVICE_BUS;
	}

	/**
	 * @return Configurator[]|string[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new CommandBusConfigurator($this->containerBuilder),
			new EventBusConfigurator($this->containerBuilder),
			new QueryBusConfigurator($this->containerBuilder),
		];
	}
}

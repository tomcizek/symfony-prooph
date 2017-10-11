<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph;

use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessagesConfigurator;
use TomCizek\SymfonyProoph\Common\CompositeConfigurator;
use TomCizek\SymfonyProoph\Common\Configurator;
use TomCizek\SymfonyProoph\EventSourcing\EventSourcingConfigurator;
use TomCizek\SymfonyProoph\EventStore\EventStoreConfigurator;
use TomCizek\SymfonyProoph\ProjectionManager\ProjectionManagerConfigurator;
use TomCizek\SymfonyProoph\ServiceBus\ServiceBusesConfigurator;

class ProophExtensionConfigurator extends CompositeConfigurator
{
	public const KEY = 'prooph';

	/**
	 * @return Configurator[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new EventStoreConfigurator($this->containerBuilder),
			new ProjectionManagerConfigurator($this->containerBuilder),
			new EventSourcingConfigurator($this->containerBuilder),
			new ServiceBusesConfigurator($this->containerBuilder),
			new AsynchronousMessagesConfigurator($this->containerBuilder),
		];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}
}

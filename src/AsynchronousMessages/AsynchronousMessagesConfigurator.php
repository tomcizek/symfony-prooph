<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages;

use TomCizek\SymfonyProoph\AsynchronousMessages\Configurators\AsynchronousCommandProducerConfigurator;
use TomCizek\SymfonyProoph\AsynchronousMessages\Configurators\AsynchronousEventProducerConfigurator;
use TomCizek\SymfonyProoph\AsynchronousMessages\Configurators\AsynchronousQueryProducerConfigurator;
use TomCizek\SymfonyProoph\Common\CompositeConfigurator;
use TomCizek\SymfonyProoph\Common\Configurator;

class AsynchronousMessagesConfigurator extends CompositeConfigurator
{
	public const KEY = 'asynchronous_messaging';

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	/**
	 * @return Configurator[]|string[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new AsynchronousCommandProducerConfigurator($this->containerBuilder),
			new AsynchronousEventProducerConfigurator($this->containerBuilder),
			new AsynchronousQueryProducerConfigurator($this->containerBuilder),
		];
	}
}

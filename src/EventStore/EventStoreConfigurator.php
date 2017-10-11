<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\EventStore;

use Prooph\EventStore\EventStore;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomCizek\SymfonyProoph\BadConfigurationException;
use TomCizek\SymfonyProoph\Common\DefaultConfigurator;

class EventStoreConfigurator extends DefaultConfigurator
{
	public const KEY = 'event_store';
	public const KEY_FACTORY = 'factory';

	public function buildDefaultConfig(): array
	{
		return [];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	public function configureWithConfig(array $config): void
	{
		$interopContainerServiceId = $this->getInteropContainerServiceId();

		foreach (array_reverse($config) as $eventStoreConfigName => $specificConfig) {

			$factory = $this->getFactoryName($specificConfig, $eventStoreConfigName);

			$eventStoreDefinition = new Definition(EventStore::class);
			$eventStoreDefinition
				->setFactory($factory . '::' . $eventStoreConfigName)
				->addArgument(
					new Reference($interopContainerServiceId)
				);

			$eventStoreDefinitionName = 'prooph.event_store.' . $eventStoreConfigName;

			$this->containerBuilder->setDefinition($eventStoreDefinitionName, $eventStoreDefinition);

			$this->containerBuilder->setAlias(EventStore::class, $eventStoreDefinitionName);
			$this->containerBuilder->setAlias('prooph.event_store', $eventStoreDefinitionName);
		}
	}

	public function getFactoryName(array $specificConfig, string $eventStoreConfigName): string
	{
		if (empty($specificConfig[self::KEY_FACTORY])) {
			throw new BadConfigurationException(
				sprintf(
					'Event store config for %s has not set factory. Please provide factory class for 
						event store under prooph.event_store.%s.factory',
					$eventStoreConfigName,
					$eventStoreConfigName
				)
			);
		}

		return $specificConfig[self::KEY_FACTORY];
	}
}

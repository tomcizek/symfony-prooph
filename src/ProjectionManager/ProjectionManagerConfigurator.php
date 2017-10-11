<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\ProjectionManager;

use Prooph\EventStore\Projection\ProjectionManager;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomCizek\SymfonyProoph\BadConfigurationException;
use TomCizek\SymfonyProoph\Common\DefaultConfigurator;

class ProjectionManagerConfigurator extends DefaultConfigurator
{
	public const KEY = 'projection_manager';
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
		$reversedConfig = array_reverse($config);

		foreach ($reversedConfig as $projectionManagerConfigName => $specificConfig) {
			$this->setDefinitionOfProjectionManager(
				$specificConfig,
				$projectionManagerConfigName
			);
		}
	}

	private function setDefinitionOfProjectionManager(
		array $specificConfig,
		string $projectionManagerConfigName
	): void {

		$referenceToInteropContainer = new Reference($this->getInteropContainerServiceId());

		$factory = $this->getFactoryName($specificConfig, $projectionManagerConfigName);

		$projectionManagerDefinition = new Definition(ProjectionManager::class);
		$projectionManagerDefinition
			->setFactory($factory . '::' . $projectionManagerConfigName)
			->addArgument($referenceToInteropContainer);

		$definitionName = 'prooph.projection_manager.' . $projectionManagerConfigName;

		$this->containerBuilder->setDefinition($definitionName, $projectionManagerDefinition);

		$this->containerBuilder->setDefinition('prooph.projection_manager', $projectionManagerDefinition);
		$this->containerBuilder->setAlias(ProjectionManager::class, $definitionName);
	}

	private function getFactoryName(array $specificConfig, string $eventStoreConfigName): string
	{
		if (empty($specificConfig[self::KEY_FACTORY])) {
			throw new BadConfigurationException(
				sprintf(
					'Projection manager config for %s has not set factory. Please provide factory class for 
						event store under prooph.event_store.%s.factory',
					$eventStoreConfigName,
					$eventStoreConfigName
				)
			);
		}

		return $specificConfig[self::KEY_FACTORY];
	}
}

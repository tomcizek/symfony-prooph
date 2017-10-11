<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Common;

use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class CompositeConfigurator extends DefaultConfigurator
{
	/** @var Configurator[] */
	public $configurators = [];

	public function __construct(ContainerBuilder $containerBuilder)
	{
		parent::__construct($containerBuilder);
		$this->configurators = $this->createConfigurators();
	}

	/**
	 * @return Configurator[]
	 */
	abstract protected function createConfigurators(): array;

	abstract public function getConfigKey(): ?string;

	public function buildDefaultConfig(): array
	{
		$config = [];
		foreach ($this->configurators as $configurator) {
			$config[$configurator->getConfigKey()] = $configurator->buildDefaultConfig();
		}

		return $config;
	}

	public function configureWithConfig(array $config): void
	{
		foreach ($this->configurators as $configurator) {
			$serviceConfig = $config[$configurator->getConfigKey()];
			$configurator->configureWithConfig($serviceConfig);
		}
	}
}

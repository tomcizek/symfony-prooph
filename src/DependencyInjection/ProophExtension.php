<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use TomCizek\SymfonyProoph\Common\ConfigArrayBuilder;
use TomCizek\SymfonyProoph\ProophExtensionConfigurator;

class ProophExtension extends Extension
{
	/** @var array */
	public $defaults = [];

	/** @var ConfigArrayBuilder */
	protected $configBuilder;

	public function load(array $configs, ContainerBuilder $containerBuilder): void
	{
		$this->configBuilder = ConfigArrayBuilder::fromConfigs($configs);

		$extensionConfigurator = new ProophExtensionConfigurator($containerBuilder);

		$this->configBuilder->mergeDefaultConfig($extensionConfigurator->buildDefaultConfig());

		$extensionConfigurator->configureWithConfig($this->configBuilder->build());
	}
}


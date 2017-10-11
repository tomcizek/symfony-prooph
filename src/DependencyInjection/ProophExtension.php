<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use TomCizek\SymfonyInteropContainer\AbstractInteropExtension;
use TomCizek\SymfonyProoph\ProophExtensionConfigurator;

class ProophExtension extends AbstractInteropExtension
{
	/** @var array */
	public $defaults = [];

	public function load(array $configs, ContainerBuilder $containerBuilder): void
	{
		parent::load($configs, $containerBuilder);

		$extensionConfigurator = new ProophExtensionConfigurator($containerBuilder);

		$this->configBuilder->mergeDefaultConfig($extensionConfigurator->buildDefaultConfig());

		$extensionConfigurator->configureWithConfig($this->configBuilder->build());
	}
}


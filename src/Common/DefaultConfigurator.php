<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Common;

use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class DefaultConfigurator implements Configurator
{
	/** @var ContainerBuilder */
	public $containerBuilder;

	public function __construct(ContainerBuilder $containerBuilder)
	{
		$this->containerBuilder = $containerBuilder;
	}

	public function getInteropContainerServiceId()
	{
		return 'interop_container';
	}
}

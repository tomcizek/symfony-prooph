<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages\Configurators;

use TomCizek\SymfonyProoph\AsynchronousMessages\Factories\AsynchronousEventProducerFactory;

class AsynchronousEventProducerConfigurator extends AbstractAsynchronousProducerConfigurator
{
	public function getProducerFactoryClass(): string
	{
		return AsynchronousEventProducerFactory::class;
	}

	public function getConfigKey(): string
	{
		return AsynchronousEventProducerFactory::SECTION_CONFIG_ID;
	}
}

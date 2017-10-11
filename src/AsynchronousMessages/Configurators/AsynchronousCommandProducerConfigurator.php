<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages\Configurators;

use TomCizek\SymfonyProoph\AsynchronousMessages\Factories\AsynchronousCommandProducerFactory;

class AsynchronousCommandProducerConfigurator extends AbstractAsynchronousProducerConfigurator
{
	public function getProducerFactoryClass(): string
	{
		return AsynchronousCommandProducerFactory::class;
	}

	public function getConfigKey(): string
	{
		return AsynchronousCommandProducerFactory::SECTION_CONFIG_ID;
	}
}

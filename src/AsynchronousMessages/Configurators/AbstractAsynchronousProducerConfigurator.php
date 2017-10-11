<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages\Configurators;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducer;
use TomCizek\SymfonyProoph\AsynchronousMessages\Factories\AbstractAsynchronousMessageProducerFactory;
use TomCizek\SymfonyProoph\Common\DefaultConfigurator;

abstract class AbstractAsynchronousProducerConfigurator extends DefaultConfigurator
{
	abstract public function getProducerFactoryClass(): string;

	public function buildDefaultConfig(): array
	{
		return [];
	}

	public function configureWithConfig(array $config): void
	{
		if (empty($config[AbstractAsynchronousMessageProducerFactory::KEY_BRIDGE])) {
			return;
		}

		$interopContainerServiceId = $this->getInteropContainerServiceId();

		$asynchronousProducerDefinition = new Definition(AsynchronousMessageProducer::class);
		$asynchronousProducerDefinition
			->setFactory($this->getProducerFactoryClass() . '::' . $this->getConfigKey())
			->addArgument(
				new Reference($interopContainerServiceId)
			);

		$asynchronousProducerName = 'prooph.asynchronous_messaging.' . $this->getConfigKey();

		$this->containerBuilder->setDefinition($asynchronousProducerName, $asynchronousProducerDefinition);
	}
}

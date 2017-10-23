<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\ServiceBus\ServiceBusConfigurators;

use Prooph\Common\Messaging\MessageFactory;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomCizek\SymfonyProoph\Common\DefaultConfigurator;

abstract class AbstractBusConfigurator extends DefaultConfigurator
{
	protected const KEY_BUS_PLUGINS = 'plugins';
	protected const KEY_BUS_ROUTER = 'router';
	protected const KEY_BUS_ROUTER_ROUTES = 'routes';
	protected const KEY_ENABLE_HANDLER_LOCATION = 'enable_handler_location';
	protected const KEY_MESSAGE_FACTORY = 'message_factory';

	abstract public function getBusClass(): string;

	abstract public function getBusFactoryClass(): string;

	public function buildDefaultConfig(): array
	{
		return [
			self::KEY_BUS_PLUGINS => [],
			self::KEY_BUS_ROUTER => [
				self::KEY_BUS_ROUTER_ROUTES => [],
			],
			self::KEY_ENABLE_HANDLER_LOCATION => true,
			self::KEY_MESSAGE_FACTORY => MessageFactory::class,
		];
	}

	public function configureWithConfig(array $config): void
	{
		$interopContainerServiceId = $this->getInteropContainerServiceId();

		$factory = $this->getBusFactoryClass();

		$serviceBusDefinition = new Definition($this->getBusClass());

		$serviceBusDefinition
			->setFactory($factory . '::' . $this->getConfigKey())
			->addArgument(
				new Reference($interopContainerServiceId)
			);

		$serviceBusDefinitionName = 'prooph.service_bus.' . $this->getConfigKey();

		$this->containerBuilder->setDefinition($serviceBusDefinitionName, $serviceBusDefinition);
		$this->containerBuilder->setAlias($this->getBusClass(), $serviceBusDefinitionName);
	}
}

<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\EventSourcing;

use Prooph\EventSourcing\Container\Aggregate\AggregateRepositoryFactory;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomCizek\SymfonyProoph\Common\DefaultConfigurator;

class EventSourcingConfigurator extends DefaultConfigurator
{
	public const KEY = 'event_sourcing';
	public const KEY_AGGREGATE_REPOSITORIES = 'aggregate_repository';
	public const KEY_REPOSITORY_CLASS = 'repository_class';

	public function buildDefaultConfig(): array
	{
		return [
			self::KEY_AGGREGATE_REPOSITORIES => [],
		];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	public function configureWithConfig(array $config): void
	{
		$repositoriesConfigs = $config[self::KEY_AGGREGATE_REPOSITORIES];

		$interopContainerServiceId = $this->getInteropContainerServiceId();

		foreach ($repositoriesConfigs as $repositoryConfigName => $repositoryConfig) {
			$repositoryClass = $repositoryConfig[self::KEY_REPOSITORY_CLASS];

			$this->setRepositoryDefinition($repositoryClass, $repositoryConfigName, $interopContainerServiceId);
			$this->setBasicAlias($repositoryClass, $repositoryConfigName);
			$this->setAliasesFromRepositoryImplementations($repositoryClass, $repositoryConfigName);
		}
	}

	private function setRepositoryDefinition(
		string $repositoryClass,
		string $repositoryConfigName,
		string $interopContainerServiceId
	): void {
		$repositoryDefinition = new Definition($repositoryClass);
		$repositoryDefinition
			->setClass($repositoryClass)
			->setFactory(AggregateRepositoryFactory::class . '::' . $repositoryConfigName)
			->addArgument(
				new Reference($interopContainerServiceId)
			);

		$this->containerBuilder->setDefinition(
			$this->getRepositoryServiceId($repositoryConfigName),
			$repositoryDefinition
		);
	}

	private function setAliasesFromRepositoryImplementations(
		string $repositoryClass,
		string $repositoryConfigName
	): void {
		$implementations = class_implements($repositoryClass);
		foreach ($implementations as $implementation) {
			$this->containerBuilder->setAlias(
				$implementation,
				$this->getRepositoryServiceId($repositoryConfigName)
			);
		}
	}

	private function setBasicAlias(string $repositoryClass, string $repositoryConfigName): void
	{
		$this->containerBuilder->setAlias(
			$repositoryClass,
			$this->getRepositoryServiceId($repositoryConfigName)
		);
	}

	private function getRepositoryPrefix(): string
	{
		return 'prooph.' . self::KEY . '.';
	}

	private function getRepositoryServiceId(string $repositoryConfigName): string
	{
		return $this->getRepositoryPrefix() . $repositoryConfigName;
	}
}

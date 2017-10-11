<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TomCizek\SymfonyProoph\ProophExtensionConfigurator;

class ProophExtensionConfiguratorTest extends TestCase
{
	public function testGetConfigKey_ShouldBeProoph()
	{
		$configurator = $this->givenProophExtensionConfigurator();

		$key = $this->whenGetConfigKey($configurator);

		$this->thenItIsExpectedString($key);
	}

	public function givenProophExtensionConfigurator(): ProophExtensionConfigurator
	{
		return new ProophExtensionConfigurator(new ContainerBuilder());
	}

	public function whenGetConfigKey(ProophExtensionConfigurator $configurator): string
	{
		return $configurator->getConfigKey();
	}

	public function thenItIsExpectedString(string $key): void
	{
		self::assertEquals('prooph', $key);
	}
}

<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\Configurators;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\ConfigFile;
use TomCizek\SymfonyProoph\ProophBundle;
use TomCizek\SymfonyProoph\Tests\TestKernel;

abstract class ProophTestCase extends TestCase
{
	const FIXTURE_CONGIGS_DIR = __DIR__ . '/fixtures/';

	/** @var ContainerInterface */
	protected $container;

	protected function givenContainerWithLoadedBundlesWithGivenConfig(
		string $configFile,
		string $configType = 'yml'
	): void {
		$kernel = $this->bootKernelWithBundlesAndGivenConfigFile($configFile, $configType);

		$this->container = $kernel->getContainer();
	}

	public function whenBootKernelWithConfig(
		string $configFile,
		string $configType = 'yml'
	): void {
		$this->bootKernelWithBundlesAndGivenConfigFile($configFile, $configType);
	}

	protected function whenGetFromContainer(string $serviceId)
	{
		return $this->container->get($serviceId);
	}

	protected function thenIsInstanceOfGivenClass($expected, $actual): void
	{
		self::assertInstanceOf($expected, $actual);
	}

	protected function thenPass(): void
	{
		self::assertTrue(true);
	}

	protected function willThrowException(string $exceptionClassName)
	{
		$this->expectException($exceptionClassName);
	}

	protected function bootKernelWithBundlesAndGivenConfigFile(
		string $configFile,
		string $configType = 'yml'
	): TestKernel {
		$kernel = $this->bootKernelWith(
			[
				SymfonyInteropContainerBundle::class,
				ProophBundle::class,
			],
			[
				ConfigFile::record(self::FIXTURE_CONGIGS_DIR . $configFile, $configType),
			]
		);

		return $kernel;
	}

	/**
	 * @param string[]     $bundles
	 * @param ConfigFile[] $configFiles
	 *
	 * @return TestKernel
	 */
	protected function bootKernelWith(array $bundles = [], array $configFiles = []): TestKernel
	{
		$randomEnvironment = bin2hex(random_bytes(10));
		$kernel = new TestKernel($randomEnvironment, true);

		$kernel->addBundleClasses($bundles);
		$kernel->addConfigFiles($configFiles);
		$kernel->boot();

		return $kernel;
	}
}

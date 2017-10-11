<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\ConfigFile;

class TestKernel extends Kernel
{
	/** @var string[] */
	private $bundlesToRegister = [];

	/** @var ConfigFile[] */
	private $configFilesToAdd = [];

	/**
	 * @param string[] $classNames
	 */
	public function addBundleClasses(array $classNames): void
	{
		foreach ($classNames as $className) {
			$this->addBundleClass($className);
		}
	}

	public function addBundleClass(string $className): void
	{
		$this->bundlesToRegister[] = $className;
	}

	/**
	 * @param ConfigFile[] $configFiles
	 */
	public function addConfigFiles(array $configFiles): void
	{
		foreach ($configFiles as $configFile) {
			$this->addConfigFile($configFile);
		}
	}

	public function addConfigFile(ConfigFile $configFile): void
	{
		$this->configFilesToAdd[] = $configFile;
	}

	/**
	 * Returns an array of bundles to register.
	 * @return BundleInterface[] An array of bundle instances
	 */
	public function registerBundles()
	{
		$instances = [];
		foreach ($this->bundlesToRegister as $className) {
			$instances[] = new $className();
		}

		return $instances;

	}

	/**
	 * Loads the container configuration.
	 *
	 * @param LoaderInterface $loader A LoaderInterface instance
	 */
	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		foreach ($this->configFilesToAdd as $configFileToAdd) {

			$loader->load($configFileToAdd->getPath(), $configFileToAdd->getType());
		}
	}
}

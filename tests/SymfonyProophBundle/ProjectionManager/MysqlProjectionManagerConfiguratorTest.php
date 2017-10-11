<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\ProjectionManager;

use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;
use TomCizek\SymfonyProoph\BadConfigurationException;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class MysqlProjectionManagerConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'ProjectionManagerTests/MysqlProjectionManagerTest.yml';
	private const FIXTURE_CONFIG_FILE_WITHOUT_FACTORY = 'Invalid//MysqlProjectionManagerWithoutFactoryTest.yml';

	public function testGetProjectionManagerByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$manager = $this->whenGetFromContainer(ProjectionManager::class);

		$this->thenIsInstanceOfGivenClass(MySqlProjectionManager::class, $manager);
	}

	public function testBootKernel_WithConfigWithoutProjectionManagerFactory_ShouldThrowBadConfigurationException()
	{
		$this->willThrowException(BadConfigurationException::class);

		$this->whenBootKernelWithConfig(self::FIXTURE_CONFIG_FILE_WITHOUT_FACTORY);
	}
}

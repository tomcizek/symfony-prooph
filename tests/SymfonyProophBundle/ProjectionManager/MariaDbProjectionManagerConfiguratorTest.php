<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\ProjectionManager;

use Prooph\EventStore\Pdo\Projection\MariaDbProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class MariaDbProjectionManagerConfiguratorTest extends ProophTestCase
{
	private const FIXTURE_CONFIG_FILE = 'ProjectionManagerTests/MariaDbProjectionManagerTest.yml';

	public function testGetProjectionManagerByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig(self::FIXTURE_CONFIG_FILE);

		$manager = $this->whenGetFromContainer(ProjectionManager::class);

		$this->thenIsInstanceOfGivenClass(MariaDbProjectionManager::class, $manager);
	}
}

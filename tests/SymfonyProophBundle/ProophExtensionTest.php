<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests;

use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\ConfigFile;
use TomCizek\SymfonyProoph\ProophBundle;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class ProophExtensionTest extends ProophTestCase
{
	public function testLoad_ByTestKernelWithThisBundleAndFullConfig_ShouldPass()
	{
		$this->whenBootWithBundleAndConfig();

		$this->thenPass();
	}

	protected function whenBootWithBundleAndConfig()
	{
		$this->bootKernelWith(
			[
				SymfonyInteropContainerBundle::class,
				ProophBundle::class,
			],
			[
				ConfigFile::record(self::FIXTURE_CONGIGS_DIR . 'FullTestConfig.yml', 'yml'),
			]
		);
	}
}

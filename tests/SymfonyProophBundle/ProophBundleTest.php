<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests;

use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyProoph\ProophBundle;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

class ProophBundleTest extends ProophTestCase
{
	public function testBuild_ByTestKernelWithThisBundle_ShouldPass()
	{
		$this->whenBootWithBundle();

		$this->thenPass();
	}

	protected function whenBootWithBundle()
	{
		$this->bootKernelWith(
			[
				SymfonyInteropContainerBundle::class,
				ProophBundle::class,
			]
		);
	}
}

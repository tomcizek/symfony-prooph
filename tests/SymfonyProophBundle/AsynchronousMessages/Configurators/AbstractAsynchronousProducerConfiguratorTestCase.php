<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducer;
use TomCizek\SymfonyProoph\Tests\Configurators\ProophTestCase;

abstract class AbstractAsynchronousProducerConfiguratorTestCase extends ProophTestCase
{
	abstract protected function getConfigFile();

	abstract protected function getExpectedServiceName();

	public function testGet_FromTestContainer_ShouldReturnAsynchronousMessageProducerInstance()
	{
		$this->givenContainerWithLoadedBundlesWithGivenConfig($this->getConfigFile());

		$producer = $this->whenGetFromContainer($this->getExpectedServiceName());

		$this->thenIsInstanceOfGivenClass(AsynchronousMessageProducer::class, $producer);
	}
}

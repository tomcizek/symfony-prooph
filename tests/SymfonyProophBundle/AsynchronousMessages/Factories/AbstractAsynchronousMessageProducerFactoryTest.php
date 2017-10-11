<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TomCizek\SymfonyProoph\AsynchronousMessages\Factories\AbstractAsynchronousMessageProducerFactory;

class AbstractAsynchronousMessageProducerFactoryTest extends TestCase
{
	public function testCallStatic_WithoutInteropContainer_ShouldThrowInvalidArgumentException()
	{
		$this->willFailWith(InvalidArgumentException::class);

		$this->whenCallStaticWithoutInteropContainer();
	}

	private function willFailWith(string $class)
	{
		$this->expectException($class);
	}

	private function whenCallStaticWithoutInteropContainer(): void
	{
		$factoryClass = $this->getFactoryClass();
		$factoryClass::callStaticWithoutInteropContainerArgument();
	}

	private function getFactoryClass(): string
	{
		return AbstractAsynchronousMessageProducerFactory::class;
	}
}

<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages\Factories;

class AsynchronousEventProducerFactory extends AbstractAsynchronousMessageProducerFactory
{
	public const SECTION_CONFIG_ID = 'events';

	public function __construct(string $configId = self::SECTION_CONFIG_ID)
	{
		parent::__construct($configId);
	}
}

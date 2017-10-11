<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\AsynchronousMessages\Factories;

class AsynchronousQueryProducerFactory extends AbstractAsynchronousMessageProducerFactory
{
	public const SECTION_CONFIG_ID = 'queries';

	public function __construct(string $configId = self::SECTION_CONFIG_ID)
	{
		parent::__construct($configId);
	}
}

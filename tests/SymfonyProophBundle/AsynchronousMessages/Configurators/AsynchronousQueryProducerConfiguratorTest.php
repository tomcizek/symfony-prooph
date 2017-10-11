<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

class AsynchronousQueryProducerConfiguratorTest extends AbstractAsynchronousProducerConfiguratorTestCase
{
	const FIXTURE_CONFIG_FILE = 'AsynchronousMessages/AsynchronousQueryProducerTest.yml';
	const EXPECTED_SERVICE_NAME = 'prooph.asynchronous_messaging.queries';

	protected function getConfigFile()
	{
		return self::FIXTURE_CONFIG_FILE;
	}

	protected function getExpectedServiceName()
	{
		return self::EXPECTED_SERVICE_NAME;
	}
}

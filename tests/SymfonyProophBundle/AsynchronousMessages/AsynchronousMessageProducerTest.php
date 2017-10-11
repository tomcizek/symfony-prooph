<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Tests\AsynchronousMessages;

use Mockery;
use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\NoOpMessageConverter;
use Prooph\ServiceBus\Exception\RuntimeException;
use Ramsey\Uuid\Uuid;
use React\Promise\Deferred;
use TomCizek\SymfonyProoph\AsynchronousMessages\AsynchronousMessageProducer;
use TomCizek\SymfonyProoph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge;
use TomCizek\SymfonyProoph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated;

class AsynchronousMessageProducerTest extends AbstractAsynchronousMessagesTestCase
{
	const TEST_PRODUCER_ROUTE_KEY = 'producerRouteKey';

	/** @var TestAsynchronousMessageProducerBridge */
	private $testProducerBridge;

	/** @var AsynchronousMessageProducer */
	private $testProducer;

	public function setUp()
	{
		parent::setUp();
		$this->givenTestProducerBridge();
		$this->givenAsynchronousMessageProducer();
	}

	public function testInvoke_WithDeferredParam_ShouldThrowRuntimeException()
	{
		$testMessage = $this->givenTestMessage();
		$deffered = $this->givenMockedDeffered();

		$this->willThrowException(RuntimeException::class);

		$this->whenInvokeProducerWith($testMessage, $deffered);
	}

	public function testInvoke_WithoutRoutes_ShouldThrowRuntimeException()
	{
		$testMessage = $this->givenTestMessage();

		$this->willThrowException(RuntimeException::class);

		$this->whenInvokeProducerWith($testMessage);
	}

	public function testInvoke_WithProperRoute_ShouldPublishExpectedMessageToExpectedProducerRouteKey()
	{
		$this->givenTestProducerHasInjectedTestRoute();

		$testMessage = $this->givenTestMessage();

		$this->whenInvokeProducerWith($testMessage);

		$this->thenShouldPublishExpectedMessageToExpectedProducerRouteKey(self::TEST_PRODUCER_ROUTE_KEY);
	}

	private function givenTestProducerBridge(): void
	{
		$this->testProducerBridge = new TestAsynchronousMessageProducerBridge();
	}

	private function givenAsynchronousMessageProducer(): void
	{
		$messageConverter = new NoOpMessageConverter();
		$this->testProducer = new AsynchronousMessageProducer($this->testProducerBridge, $messageConverter);
	}

	private function givenMockedDeffered(): Deferred
	{
		$deffered = Mockery::mock('React\Promise\Deferred');
		assert($deffered instanceof Deferred);

		return $deffered;
	}

	private function givenTestProducerHasInjectedTestRoute()
	{
		$this->testProducer->injectRoutes(
			[
				TestAggregateCreated::class => self::TEST_PRODUCER_ROUTE_KEY,
			]
		);
	}

	private function givenTestMessage(): Message
	{
		return TestAggregateCreated::create(Uuid::uuid4());
	}

	private function whenInvokeProducerWith(Message $message, Deferred $deferred = null): void
	{
		$producer = $this->testProducer;
		$producer($message, $deferred);
	}

	protected function getPublishedEventsFromTestBridge(): array
	{
		return $this->testProducerBridge->getPublished();
	}
}

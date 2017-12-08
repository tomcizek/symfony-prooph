<?php

namespace TomCizek\SymfonyProoph\AsynchronousMessages;

use Prooph\Common\Messaging\Message;

interface AsynchronousMessageProducerBridge
{
	public function publishWithRoutingKey(Message $message, string $routingKey): void;
}

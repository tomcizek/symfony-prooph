<?php

namespace TomCizek\SymfonyProoph\AsynchronousMessages;

interface AsynchronousMessageProducerBridge
{
	public function publishWithRoutingKey($routingKey, $data): void;
}

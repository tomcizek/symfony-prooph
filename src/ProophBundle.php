<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProophBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	}
}


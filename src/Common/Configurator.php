<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Common;

interface Configurator
{
	public function getConfigKey(): ?string;

	public function buildDefaultConfig(): array;

	public function configureWithConfig(array $config): void;
}

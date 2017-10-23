<?php declare(strict_types = 1);

namespace TomCizek\SymfonyProoph\Common;

class ConfigArrayBuilder
{
	private $configs = [];

	private function __construct(array $configs)
	{
		$this->mergeOverByConfigs($configs);
	}

	public function mergeOverByConfigs(array $configs): self
	{
		foreach ($configs as $config) {
			$this->mergeOverByConfig($config);
		}

		return $this;
	}

	public function mergeOverByConfig(array $config): self
	{
		$this->configs[] = $config;

		return $this;
	}

	public static function fromConfigs(array $configs = []): self
	{
		return new self($configs);
	}

	public function mergeDefaultConfig(array $config): self
	{
		array_unshift($this->configs, $config);

		return $this;
	}

	public function build(): array
	{
		$builtConfig = [];
		foreach ($this->configs as $overridingConfig) {
			$builtConfig = $this->mergeConfigs($overridingConfig, $builtConfig);
		}

		return $builtConfig;
	}

	private function mergeConfigs(array $overridingConfig, array $overriddenConfig): array
	{
		return array_replace_recursive($overriddenConfig, $overridingConfig);
	}

}

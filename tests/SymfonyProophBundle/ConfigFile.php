<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests\Configurators;

class ConfigFile
{
	/** @var string */
	private $path;

	/** @var string */
	private $type;

	private function __construct(string $path, string $type)
	{
		$this->path = $path;
		$this->type = $type;
	}

	public static function record(string $path, string $type)
	{
		return new self($path, $type);

	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getType(): string
	{
		return $this->type;
	}
}

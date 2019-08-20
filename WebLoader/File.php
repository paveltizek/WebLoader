<?php

declare(strict_types = 1);

namespace WebLoader;

class File
{

	/**
	 * @var string
	 */
	protected $file;

	/**
	 * @var int
	 */
	protected $lastModified = null;

	/**
	 * @var array
	 */
	protected $sourceFiles;


	public function __construct(
		string $file,
		?int $lastModified,
		array $sourceFiles
	)
	{
		$this->file = $file;
		$this->lastModified = $lastModified;
		$this->sourceFiles = $sourceFiles;
	}


	public function getFile(): string
	{
		return $this->file;
	}


	public function getLastModified(): ?int
	{
		return $this->lastModified;
	}


	public function getSourceFiles(): array
	{
		return $this->sourceFiles;
	}

}

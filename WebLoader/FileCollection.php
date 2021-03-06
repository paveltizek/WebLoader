<?php

declare(strict_types = 1);

namespace WebLoader;

/**
 * FileCollection
 *
 * @author Jan Marek
 */
class FileCollection implements \WebLoader\IFileCollection
{

	/** @var string */
	private $root;

	/** @var array */
	private $files = [];

	/** @var array */
	private $watchFiles = [];

	/** @var array */
	private $remoteFiles = [];


	/**
	 * @param string|null $root files root for relative paths
	 */
	public function __construct(?string $root = null)
	{
		$this->root = $root;
	}


	/**
	 * Get file list
	 */
	public function getFiles(): array
	{
		return array_values($this->files);
	}


	/**
	 * Make path absolute
	 *
	 * @throws \WebLoader\FileNotFoundException
	 */
	public function cannonicalizePath(string $path): string
	{
		$rel = Path::normalize($this->root . '/' . $path);
		if (file_exists($rel)) {
			return $rel;
		}

		$abs = Path::normalize($path);
		if (file_exists($abs)) {
			return $abs;
		}

		throw new \WebLoader\FileNotFoundException("File '$path' does not exist.");
	}


	/**
	 * Add file
	 * @param string|\SplFileInfo
	 */
	public function addFile($file): void
	{
		$file = $this->cannonicalizePath((string) $file);

		if (in_array($file, $this->files, true)) {
			return;
		}

		$this->files[] = $file;
	}


	/**
	 * Add files
	 * @param array|\Traversable $files array list of files
	 */
	public function addFiles($files): void
	{
		foreach ($files as $file) {
			$this->addFile($file);
		}
	}


	/**
	 * Remove file
	 * @param $file string filename
	 */
	public function removeFile(string $file): void
	{
		$this->removeFiles([$file]);
	}


	/**
	 * Remove files
	 * @param array $files list of files
	 */
	public function removeFiles(array $files): void
	{
		$files = array_map([$this, 'cannonicalizePath'], $files);
		$this->files = array_diff($this->files, $files);
	}


	/**
	 * Add file in remote repository (for example Google CDN).
	 * @param string $file URL address
	 */
	public function addRemoteFile(string $file): void
	{
		if (in_array($file, $this->remoteFiles, true)) {
			return;
		}

		$this->remoteFiles[] = $file;
	}


	/**
	 * Add multiple remote files
	 * @param array|\Traversable $files
	 */
	public function addRemoteFiles($files): void
	{
		foreach ($files as $file) {
			$this->addRemoteFile($file);
		}
	}


	/**
	 * Remove all files
	 */
	public function clear(): void
	{
		$this->files = [];
		$this->watchFiles = [];
		$this->remoteFiles = [];
	}


	public function getRemoteFiles(): array
	{
		return $this->remoteFiles;
	}


	public function getRoot(): string
	{
		return $this->root;
	}


	/**
	 * Add watch file
	 */
	public function addWatchFile(string $file): void
	{
		$file = $this->cannonicalizePath((string) $file);

		if (in_array($file, $this->watchFiles, true)) {
			return;
		}

		$this->watchFiles[] = $file;
	}


	/**
	 * Add watch files
	 * @param array|\Traversable $files array list of files
	 */
	public function addWatchFiles($files): void
	{
		foreach ($files as $file) {
			$this->addWatchFile($file);
		}
	}


	/**
	 * Get watch file list
	 */
	public function getWatchFiles(): array
	{
		return array_values($this->watchFiles);
	}
}

<?php
namespace Plateau\Garage;
use File;
use Illuminate\Filesystem\FileNotFoundException;

/* Simple class that leverage the use of relative path for accessing 
	in a local filesystem */
class FileDepot {
	
	protected $storagePath;

	public function __construct($path)
	{
		$this->storagePath = $path;
	}

	/**
	 * Determine if a file exists.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public function exists($path)
	{
		return File::exists($this->computePath($path));
	}

	/**
	 * Get the contents of a file.
	 *
	 * @param  string  $path
	 * @return string
	 *
	 * @throws FileNotFoundException
	 */
	public function get($path)
	{
		return File::get($this->computePath($path));
	}

	/**
	 * Get the returned value of a file.
	 *
	 * @param  string  $path
	 * @return mixed
	 *
	 * @throws FileNotFoundException
	 */
	public function getRequire($path)
	{
		return File::getRequire($this->computePath($path));
	}

	/**
	 * Require the given file once.
	 *
	 * @param  string  $file
	 * @return mixed
	 */
	public function requireOnce($file)
	{
		return File::requireOnce($this->computePath($path));
	}

	/**
	 * Write the contents of a file.
	 *
	 * @param  string  $path
	 * @param  string  $contents
	 * @return int
	 */
	public function put($path, $contents)
	{
		return File::put($this->computePath($path), $contents);
	}

	/**
	 * Prepend to a file.
	 *
	 * @param  string  $path
	 * @param  string  $data
	 * @return int
	 */
	public function prepend($path, $data)
	{
		return File::prepend($this->computePath($path), $data);
	}

	/**
	 * Append to a file.
	 *
	 * @param  string  $path
	 * @param  string  $data
	 * @return int
	 */
	public function append($path, $data)
	{
		return File::append($this->computePath($path), $data);
	}

	/**
	 * Delete the file at a given path.
	 *
	 * @param  string|array  $paths
	 * @return bool
	 */
	public function delete($paths)
	{
		return File::delete($this->computePath($path));
	}

	/**
	 * Move a file to a new location.
	 *
	 * @param  string  $path
	 * @param  string  $target
	 * @return bool
	 */
	public function move($path, $target)
	{
		return File::move($this->computePath($path), $this->computePath($target));
	}

	/**
	 * Copy a file to a new location.
	 *
	 * @param  string  $path
	 * @param  string  $target
	 * @return bool
	 */
	public function copy($path, $target)
	{
		return File::copy($this->computePath($path), $this->computePath($target));
	}

	/**
	 * Extract the file extension from a file path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function extension($path)
	{
		return File::extension($this->computePath($path));
	}

	/**
	 * Get the file type of a given file.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function type($path)
	{
		return File::type($this->computePath($path));
	}

	/**
	 * Get the file size of a given file.
	 *
	 * @param  string  $path
	 * @return int
	 */
	public function size($path)
	{
		return File::size($this->computePath($path));
	}

	/**
	 * Get the file's last modification time.
	 *
	 * @param  string  $path
	 * @return int
	 */
	public function lastModified($path)
	{
		return File::lastModified($this->computePath($path));
	}

	/**
	 * Determine if the given path is a directory.
	 *
	 * @param  string  $directory
	 * @return bool
	 */
	public function isDirectory($directory)
	{
		return File::isDirectory($this->computePath($path));
	}

	/**
	 * Determine if the given path is writable.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public function isWritable($path)
	{
		return File::isWritable($this->computePath($path));
	}

	/**
	 * Determine if the given path is a file.
	 *
	 * @param  string  $file
	 * @return bool
	 */
	public function isFile($file)
	{
		return File::isFile($this->computePath($path));
	}

	/**
	 * Find path names matching a given pattern.
	 *
	 * @param  string  $pattern
	 * @param  int     $flags
	 * @return array
	 */
	public function glob($pattern, $flags = 0)
	{
		return File::glob($pattern, $flags);
	}

	/**
	 * Get an array of all files in a directory.
	 *
	 * @param  string  $directory
	 * @return array
	 */
	public function files($directory)
	{
		return File::files($this->computePath($directory));
	}

	/**
	 * Get all of the files from the given directory (recursive).
	 *
	 * @param  string  $directory
	 * @return array
	 */
	public function allFiles($directory)
	{
		return File::allFiles($this->computePath($directory));
	}

	/**
	 * Get all of the directories within a given directory.
	 *
	 * @param  string  $directory
	 * @return array
	 */
	public function directories($directory)
	{
		return File::directories($this->computePath($path));
	}

	/**
	 * Create a directory.
	 *
	 * @param  string  $path
	 * @param  int     $mode
	 * @param  bool    $recursive
	 * @param  bool    $force
	 * @return bool
	 */
	public function makeDirectory($path, $mode = 0777, $recursive = false, $force = false)
	{
		return File::makeDirectory($this->computePath($path), $mode, $recursive, $force);
	}

	/**
	 * Copy a directory from one location to another.
	 *
	 * @param  string  $directory
	 * @param  string  $destination
	 * @param  int     $options
	 * @return bool
	 */
	public function copyDirectory($directory, $destination, $options = null)
	{
		return File::copyDirectory($this->computePath($directory), $this->computePath($destination), $options);	
	}

	/**
	 * Recursively delete a directory.
	 *
	 * The directory itself may be optionally preserved.
	 *
	 * @param  string  $directory
	 * @param  bool    $preserve
	 * @return bool
	 */
	public function deleteDirectory($directory, $preserve = false)
	{
		return File::deleteDirectory($this->computePath($directory), $preserve);	
	}

	/**
	 * Empty the specified directory of all files and folders.
	 *
	 * @param  string  $directory
	 * @return bool
	 */
	public function cleanDirectory($directory)
	{
		return File::cleanDirectory($this->computePath($directory));
	}



	/**
	 * 
	 */
	public function upload($localPath, $distantPath)
	{
		if(File::exists($localPath))
		{
			if (File::isDirectory($localPath))
			{
				return File::copyDirectory($localPath, $this->computePath($distantPath));
			}
			else
			{
				return File::copy($localPath, $this->computePath($distantPath));
			}
		}
	}

	/*
	 *
	 */
	public function download($path, $localPath)
	{
		if($this->exists($path))
		{
			if ($this->isDirectory($path))
			{
				return File::copyDirectory($this->computePath($path), $localPath);
			}
			else
			{
				return File::copy($this->computePath($path), $localPath);
			}
		}
	}

	public function md5($path)
	{
		return md5_file($this->computePath($path));
	}

	protected function computePath($path)
	{
		$path = $this->storagePath.'/'.$path;
		
		$this->ensureDirExists($path);
		
		return $path;
	}
	
	protected function ensureDirExists($path)
	{
		$parts = explode('/', $path);
		unset($parts[count($parts)-1]);
		$path = implode('/', $parts);
		
		if (!File::isDirectory($path)) {
			throw new FileNotFoundException($path);
		}
	}
}
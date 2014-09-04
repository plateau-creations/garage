<?php
namespace Plateau\Garage\Repositories;

use Plateau\Garage\Models\File;
use Plateau\Garage\Models\Volume;
use Plateau\Garage\FileDepot;

class FileCatalog {
	

	public function getNew()
	{
		return new File();
	}

	public function allFiles()
	{
		return File::all();
	}

	// Find a file by it's checksum
	public function findByMd5($md5, Volume $volume)
	{
		$file = File::whereMd5($md5)->first();

		if($file)
		{
			return $file;
		}
		else return null;
	}

	public function findByPath($path, Volume $volume)
	{
		$file = File::where('volume_id', '=', $volume->id)->where('path', '=', $path)->first();

		if ($file)
		{	
			
			return true;
		}
		else return false;
	}

	public function allFilesIn($volumeId)
	{
		return File::where('volume_id', '=', $volumeId)->get();
	}


	public function getVolume(File $file)
	{
		return $file->volume()->first();
	}

	public function checkCrc(File $file)
	{
		$volume = $this->getVolume($file);

		$depot = $volume->getDepot();

		if($depot->md5($file->path) == $file->md5)
		{
			return true;
		}
		else return false;
	}
	
}
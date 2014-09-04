<?php
namespace Plateau\Garage;

use Illuminate\Foundation\Application;

use Plateau\Garage\Models\Volume;
use Plateau\Garage\Models\File;
use Plateau\Garage\Repositories\FileCatalog;
use Plateau\Garage\Scripts\VolumeUpdater;
use Plateau\Garage\Scripts\UpdateReport;

class Garage {


	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function volumes()
	{
		return Volume::all();
	}


	public function hasVolume($label)
	{
		$volume = Volume::whereLabel($label)->first();

		return $volume ? true : false;
	}

	public function files(Volume $volume)
	{
		return $volume->files()->get();
	}

	/*public function allFiles()
	{
		$volumes = $this->volumes();

		$allFiles = array();

		foreach($volumes as $volume)
		{
			$depot = new FileDepot($volume->path);

			foreach($volume->files()->get() as $file)
			{
				$allFiles[] = $depot->getAbsolutePath($file->path);
			} 
		}

		return $allFiles;
	}*/


	public function allFiles()
	{
		$volumes = $this->volumes();

		$x=0;

		foreach($volumes as $volume)
		{
			if ($x==0)
			{
				$files = $volume->files()->get();
			}
			else 
			{
				$files->merge($volume->files()->get());
			}
			$x++;
		}

		return $files;
	}

	public function getVolume($path)
	{
		$volume = Volume::wherePath($path)->first();

		if ($volume) 
		{
			return $volume;
		}
		else return false;
	}

	public function getVolumeByLabel($label)
	{
		$volume = Volume::whereLabel($label)->first();

		if ($volume) 
		{
			return $volume;
		}
		else return false;
	}

	public function addVolume($path, $label = null)
	{
		// Check if path exist
		$filesystem = $this->app->make('files');

		if ($filesystem->exists($path) && $filesystem->isDirectory($path))
		{

			// Add volume
			if (! $volume = $this->getVolume($path))
			{
				$volume = new Volume;

				if ($label)
				{
					$volume->label = $label;
				}
				else
				{
					$volume->label = $path;
				}

				$volume->path = $path;

				$volume->save();
			}

			// Update Volume

			$updater = new VolumeUpdater($volume, new FileCatalog);

			return $updater->update();
		}
		else
		{
			return false;
		}
		

		
	}


	public function update($label)
	{
		if ($volume = $this->getVolumeByLabel($label))
		{
			$updater = new VolumeUpdater($volume, new FileCatalog);

			return $updater->update();
		}
	}

	public function updateAllVolumes()
	{
		$volumes = $this->volumes();

		$updateReport = new UpdateReport();

		foreach ($volumes as $volume)
		{

			$report = $this->update($volume->label);

			foreach ($report->getMessages() as $message)
			{
				$updateReport->log($message);
			}
		}

		return $updateReport;
	}


}
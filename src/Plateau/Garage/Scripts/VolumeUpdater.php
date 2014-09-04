<?php
namespace Plateau\Garage\Scripts;

use Plateau\Garage\FileDepot;
use Plateau\Garage\Models\Volume;
use Plateau\Garage\Repositories\FileCatalog;
use Log;

class VolumeUpdater {

	protected $fileCatalog;

	protected $volume;

	// Instance of FileDepotInterface
	protected $fileDepot;

	protected $updateReport;

	public function __construct(Volume $volume, FileCatalog $fileCatalog)
	{
		$this->volume = $volume;
		$this->fileCatalog = $fileCatalog;
		$this->fileDepot = $volume->getDepot();		
		$this->updateReport = new UpdateReport;
	}

	public function update()
	{
		$filesInDepot = $this->fileDepot->allFiles();

		foreach($filesInDepot as $file)
		{
			// extract relative path from SplFileInfo Object
			$path = $file->getRelativePathname($file);

			// Check by filename
			if ($this->fileCatalog->findByPath($path, $this->volume))
			{
				continue;
			}

			// Calculate md5
			$md5 = $this->fileDepot->md5($path);

			// Check by md5
			if ($existingFile = $this->fileCatalog->findByMd5($md5, $this->volume) )
			{
				// Skip 0 sized files
				if ($existingFile->size == 0) continue;

				// if found -> rename file in catalog
				$this->updateReport->log('Le fichier ' . $existingFile->path ." a été renommé en ".$path);

				$existingFile->path = $path;
				$existingFile->save();
				
				
				continue;
			}
			
			$newFile = $this->fileCatalog->getNew();
			$newFile->path = $path;
			$newFile->md5 = $md5;
			$newFile->size = $this->fileDepot->size($path);
			$newFile->volume_id = $this->volume->id;
			$newFile->save();
			$this->updateReport->log('Le fichier ' . $path ." a été ajouté");
		}

		// Now check for missing files
		$this->findMissingFiles();

		return $this->updateReport;
	}

	protected function findMissingFiles()
	{
		$files = $this->volume->files()->get();

		foreach ($files as $file)
		{
			if (! $this->fileDepot->exists($file->path))
			{
				$this->updateReport->log('Le fichier ' . $file->path  ." a été supprimé.");

				$file->delete();
			}
		}
	}
	
}
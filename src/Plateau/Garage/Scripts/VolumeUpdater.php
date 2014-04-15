<?php
namespace Plateau\Garage\Volumes;

use Plateau\Garage\FileDepot;

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
		$this->fileDepot = new $volume->getDepot();		
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
			$md5 = $this->fileDepot->md5($file);

			// Check by md5
			if ($existingFile = $this->fileCatalog->findByMd5($md5, $this->volume) )
			{
				// if found -> rename file in catalog
				//  NOTE : We might consider additionnal checks,
				//  as file of size 0, 1, 2, etc are likely to produce
				//  identical md5. 
				
				continue;
			}
			
			$newFile = $this->fileCatalog->getNew();
			$newFile->path = $path;
			$newFile->md5 = $md5;
			$newFile->size = $this->fileDepot->size($file);
			$newFile->save();
		}

		return $this->updateReport;
	}

	
}
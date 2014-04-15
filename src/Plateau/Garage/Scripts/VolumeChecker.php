<?php
namespace Plateau\Garage\Scripts;

use Plateau\Garage\Models\Volume;

// Check Volume Integrity
// 
class VolumeChecker {
	
	protected $volume;
	
	protected $fileCatalog;

	protected $fileDepot;

	protected $crcCheck = false;

	public function __construct(Volume $volume, FileCatalog $fileCatalog)	
	{
		$this->volume = $volume;

		$this->fileDepot = new FileDepot($volume->path);

		$this->fileCatalog = $fileCatalog;
	}

	public function activateCrcCheck()
	{
		$this->crcCheck = true;
	}


	public function check()
	{
		$files = $this->fileCatalog->allFilesIn($this->volume->id);

		$report = new CheckerReport;

		foreach($files as $file)
		{
			// Check file existence
			if ($this->fileDepot->exists($file->path) )
			{
				if ($this->crcCheck)
				{
					if( ! $file->crc == $this->fileDepot->crc($file->path))
					{
						$report->addError($file, 'Erreur de contrôle cyclique');
					}
				}
			}
			else
			{
				$report->addError($file, 'Fichier non trouvé.');
			}
			$report->increments();
		}

		return $report;
	}
}
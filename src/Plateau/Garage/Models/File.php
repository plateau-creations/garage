<?php
namespace Plateau\Garage\Models;

use Plateau\Garage\FileDepot;
use Eloquent;
use App;

class File extends Eloquent {

	public function __construct()
	{
		$this->table = App::make('config')->get('garage::db_prefix').'files';
		parent::__construct();
	}

	public function volume()
	{
		return $this->belongsTo('Plateau\Garage\Models\Volume');
	}

	public function getAbsolutePath()
	{
		$volume = $this->volume()->first();

		$depot = new FileDepot($volume->path);

		return $depot->getAbsolutePath($this->path);
	}	
}
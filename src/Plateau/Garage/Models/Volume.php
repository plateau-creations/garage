<?php
namespace Plateau\Garage\Models;
use Plateau\Garage\FileDepot;

use Eloquent;
use App;

class Volume extends Eloquent {
	
	public $timestamps = false;

	public function __construct()
	{
		$this->table = App::make('config')->get('garage::db_prefix').'volumes';
		parent::__construct();
	}

	public function files()
	{
		return $this->hasMany('Plateau\Garage\Models\File');
	}

	public function getDepot()
	{
		return new FileDepot($this->path);
	}	
}
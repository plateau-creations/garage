<?php
namespace Plateau\Garage\Models;

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
	
}
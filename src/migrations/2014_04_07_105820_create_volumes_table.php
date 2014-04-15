<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolumesTable extends Migration {

	protected $dbPrefix;

	public function __construct()
	{
		$this->dbPrefix = Config::get('garage::db_prefix');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create($this->dbPrefix.'volumes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('label');
			$table->string('path'); // Base Path of the volume
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop($this->dbPrefix.'volumes');
	}

}

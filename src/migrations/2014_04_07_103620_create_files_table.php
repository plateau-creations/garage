<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

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
		Schema::create($this->dbPrefix.'files', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('md5',32);	// MD5 Checksum for checking file integrity
			$table->string('path'); // Full Path Relative to the volume root
			$table->integer('size');
			$table->integer('volume_id');
			$table->timestamps();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->dbPrefix.'files');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingFlagToFiles extends Migration {

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
		Schema::table($this->dbPrefix.'files', function (Blueprint $table) {
			$table->boolean('missing')->default(false);
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table($this->dbPrefix.'files', function (Blueprint $table) {
			$table->dropColumn('missing');
		});
	}

}

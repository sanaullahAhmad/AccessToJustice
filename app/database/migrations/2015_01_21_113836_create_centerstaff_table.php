<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCenterStaffTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('center_staff', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('designation');
			$table->string('phone');
			$table->string('email');
			$table->string('trained');
			$table->integer('center_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('center_staff');
	}

}

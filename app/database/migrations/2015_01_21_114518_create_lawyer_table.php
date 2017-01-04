<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLawyerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lawyers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('gender');
			$table->string('phone');
			$table->string('experience');
			$table->string('bar_name');
			$table->string('bar_address');
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
		Schema::drop('lawyers');
	}

}

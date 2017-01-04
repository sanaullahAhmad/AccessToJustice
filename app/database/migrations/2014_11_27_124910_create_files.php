<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('path');
			$table->text('comments');
			$table->string('type');
			$table->string('owner_type');
			$table->integer('owner_id');

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
		Schema::create('files', function(Blueprint $table)
		{
			Schema::drop('files');
		});
	}

}

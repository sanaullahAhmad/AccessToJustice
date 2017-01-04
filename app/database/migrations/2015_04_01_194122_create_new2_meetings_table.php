<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNew2MeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('meetings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('date');
			$table->text('rightbased_org');
			$table->text('goveronment_deps');
			$table->text('political_personalities');
			$table->text('district_bar');
			$table->integer('district_id');
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
		Schema::drop('meetings');
	}

}

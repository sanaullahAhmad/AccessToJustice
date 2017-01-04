<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSycopMobileTable4 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sycop_calls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('date');
			$table->string('first_follow');
			$table->string('gender');
			$table->string('contact_no');
		 
			$table->string('caller_district');
			$table->string('call_reason');
			$table->string('callback');
			$table->string('refered_from');
			$table->string('refered_to');
			$table->string('refer');
			$table->string('staff_name');
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
		Schema::drop('sycop_calls');
	}

}

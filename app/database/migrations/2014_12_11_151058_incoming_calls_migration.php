<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncomingCallsMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incoming_calls', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('date');
			$table->string('time');
			$table->string('gender');
			$table->string('age');
			$table->string('contact');
			$table->string('cnic');
			$table->string('occupation');
			$table->string('call_type');
			$table->string('address');
			$table->string('marital_status');
			$table->integer('call_nature_id');
			$table->string('relation');
			$table->integer('call_purpose_id');
			$table->integer('priority_group_id');
			$table->integer('minority_group_id');
			$table->string('psychosocial_support');
			$table->integer('case_nature_id');
			$table->string('action_taken');
			$table->string('refer');
			$table->string('callback_option');
			$table->string('refer_from');
			$table->string('crank_call');
			$table->string('rating_string');
			$table->string('helpline_mobile');
			$table->string('call_taken_by');
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
			Schema::drop('incoming_calls');
	}

}

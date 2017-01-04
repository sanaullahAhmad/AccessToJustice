<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutgoingcalls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		/*
			name , date , call_type , gender , contact , address , priority_group_id , minority_group_id ,
			case_nature , action_taken , refer , call_taken_by , call_taken_by , center_id 
		*/

		Schema::create('outgoing_calls', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('date');
			$table->string('call_type');
			$table->string('gender');
			$table->string('contact');
			$table->string('address');
			$table->integer('priority_group_id');
			$table->integer('minority_group_id');
			$table->integer('case_nature_id');
			$table->string('action_taken');
			$table->string('refer');
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
		Schema::drop('outgoing_calls');
	}

}

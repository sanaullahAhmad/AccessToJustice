<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCenterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('centers', function(Blueprint $table)
		{
			$table->increments('id');

			/*
				name , address , timings , phone , mobile , 
				district_id , partner_id , coordinator , coordinator-number
			*/
				
			$table->string('name');
			$table->string('address');
			$table->string('timings');
			$table->string('phone');
			$table->string('mobile');
			$table->integer('district_id');
			$table->integer('partner_id');
			$table->string('coordinator');
			$table->string('coordinator-number');

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
		Schema::drop('centers');
	}

}

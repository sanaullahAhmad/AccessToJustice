<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		/*
			name , address , website , experience , experience-summary , focal-person , 
			focal-person-designation , focal-person-phone , district_id 
		*/

		Schema::create('partners', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('address');
			$table->string('website');
			$table->integer('experience');
			$table->text('experience-summary');
			$table->string('focal-person');
			$table->string('focal-person-designation');
			$table->string('focal-person-phone');
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
		Schema::drop('partners');
	}

}

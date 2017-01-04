<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WalkinMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('walkins', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string("name");
			$table->string("date");
			$table->string("first_follow_visit");
			$table->string("gender");
			$table->string("age");
			$table->string("contact");
			$table->string("cnic");
			$table->string("occupation");
			$table->string("address");
			$table->string("tehsil");
			$table->string("visit_type");
			$table->string("visit_reason");
			$table->string("heard_from");
			$table->string("thumb_impression");
			$table->string("ratings");
			$table->integer("center_id");

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
		Schema::drop('legalaids');
	}

}

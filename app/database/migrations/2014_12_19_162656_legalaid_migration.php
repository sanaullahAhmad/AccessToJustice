<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LegalaidMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('legalaids', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string("name");
			$table->string("date");
			$table->string("gender");
			$table->string("age");
			$table->string("contact");
			$table->string("occupation");
			$table->string("first_follow_visit");
			$table->string("address");
			$table->string("marital_status");
			$table->string("visit_type");
			$table->string("visit_reason");
			$table->string("relation_with_client");
			$table->integer("priority_group_id");
			$table->integer("minority_group_id");
			$table->string("psychosocial_support");
			$table->integer("case_type_id");
			$table->string("action_taken");
			$table->string("referred_to");
			$table->string("callback");
			$table->string("heard_from");
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

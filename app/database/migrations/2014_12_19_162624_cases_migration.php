<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CasesMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cases', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string("name");
			$table->string("contact");
			$table->string("gender");
			$table->string("age");
			$table->string("cnin");
			$table->string("occupation");
			$table->string("marital_status");
			$table->string("address");
			$table->string("tehsil");
			$table->string("guardian");
			$table->string("relation_with_guardian");
			$table->string("contact_guardian");
			$table->integer("priority_group_id");
			$table->integer("minority_group_id");
			$table->string("psychosocial_support");
			$table->integer("case_type_id");
			$table->integer("problem_nature_id");
			$table->string("action_taken");
			$table->string("court_name");
			$table->string("lawyer_name");
			$table->string("lawyer_cell_no");
			$table->string("cost");
			$table->string("date_of_case");
			$table->string("case_number");
			$table->string("referred_from");
			$table->string("stage_proceeding");
			$table->string("decision");
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
		Schema::drop('cases');
	}

}

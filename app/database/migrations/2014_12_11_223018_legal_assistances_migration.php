<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LegalAssistancesMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('legal_assistances', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('contact');
			$table->string('gender');
			$table->string('age');
			$table->string('cnic');
			$table->string('occupation');
			$table->string('marital_status');
			$table->string('address');
			$table->string('tehsil');
			$table->string('guardian');
			$table->string('relation_with_guardian');
			$table->string('contact_guardian');
			$table->integer('priority_group_id');
			$table->integer('minority_group_id');
			$table->string('psychosocial_support');
			$table->integer('problem_nature_id');
			$table->string('action_taken');
			$table->string('institution');
			$table->string('lawyer_name');
			$table->string('lawyer_cell_no');
			$table->string('date_of_documents');
			$table->string('referred_from');
			$table->string('stage_proceeding');
			$table->string('decision');
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
		Schema::drop('legal_assistances');
	}

}

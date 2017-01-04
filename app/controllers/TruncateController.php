<?php

class TruncateController extends \BaseController {

	public $tables_headings=array(
			"Walkins",
			"Court Cases",
			"Incoming Calls",
			"Outgoing Calls",
			"Legal Assistance",
			"Legal Advice",
			"Sycop"
		);

	public $models=[

		"Walkin",
		"CourtCase",
		"IncomingCall",
		"OutgoingCall",
		"LegalAssistance",
		"LegalAid",
		"SycopCall"

	];

	public function index(){
		
		return View::make('layouts.records.truncate')->with('data',$this->tables_headings);

	}


	public function truncate($id){

		// $id=Input::get('id');
		$model=$this->models[$id];

		$model::truncate();


		return Redirect::to('213dsde');

	}



}
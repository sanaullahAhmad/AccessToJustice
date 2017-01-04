<?php

class CenterIecController extends \BaseController{

	/*
		@return View->centers_iec
	*/

	public function index(){

		if(Auth::check() && Entrust::hasRole('Center_User')){
			return Redirect::route('iec.index',
						array(
							'owner_id'=>Confide::user()->center()->first()->id,
							'owner_type'=>'iec'
							)
					);
		}

		$centers=Center::getAllRecords();

		$data=array(
			'centers'=>$centers,
			'current_route_base'=>'iec',
			'heading'=>'IEC Material',
			'iec_link'=>'iec.index'
		);

		return View::make('layouts.centers_iec')->with(array('data'=>$data));
	}
}
?>
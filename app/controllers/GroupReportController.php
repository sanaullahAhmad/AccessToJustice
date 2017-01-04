<?php

class GroupReportController extends \BaseController {

	public function cases(){

		$natures=retrieveField(CaseNature::all(),'name');

		$pgroup=retrieveField(PriorityGroup::all(),'name');

		$data=[];

		// $total=CourtCases::all()->count();

		foreach ($pgroup as $key=>$value) {
			
					

			$natures=CourtCase::where('priority_group_id','=',$key)->groupBy('case_nature_id')->get();
			if(trim($value)=='GBV'){
					$value='Gender Based Violence';
				}
			if(count($natures)>0){
				$data[$value]=[];
			}
 

			foreach ($natures as $nature) {
				
				$count=CourtCase::where('case_nature_id','=',$nature->case_nature()->first()->id)->where('priority_group_id','=',$key)->count();
				$name=$nature->case_nature()->first()->name;
				 
				array_push($data[$value],[$name,$count]);		
			}


			if(count($natures)>0){
				
				array_push($data[$value],['Total',CourtCase::where('priority_group_id','=',$key)->count()]);
			}
	
		}

		$json=json_encode($data);


		return View::make('layouts.records.group_analysis')->with(['data'=>$data,'json'=>$json]);

	}


	public function legal(){
		
		$natures=retrieveField(ProblemNature::all(),'name');

		$pgroup=retrieveField(PriorityGroup::all(),'name');

		// dd($pgroup);

		$data=[];

		foreach ($pgroup as $key=>$value) {

			$natures=LegalAssistance::where('priority_group_id','=',$key)->groupBy('problem_nature_id')->get();
				if(trim($value)=='GBV'){
					$value='Gender Based Violence';
				}
			if(count($natures)>0){
				$data[$value]=[];
			}

			foreach ($natures as $nature) {

				$count=CourtCase::where('problem_nature_id','=',$nature->problem_nature()->first()->id)->where('priority_group_id','=',$key)->count();
				$name=$nature->case_nature()->first()->name;
			
				array_push($data[$value],[$name,$count]);								 
			}

			if(count($natures)>0){
				
				array_push($data[$value],['Total',LegalAssistance::where('priority_group_id','=',$key)->count()]);
			}
	
		}

		$json=json_encode($data);

		return View::make('layouts.records.group_analysis')->with(['data'=>$data,'json'=>$json]);


	}
}

?>
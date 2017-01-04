<?php

class ReportsController extends \BaseController {

	private $db_tables=["walkins","legalaids","incoming_calls","outgoing_calls","legal_assistances","cases","sycop_calls"];
	private $result_keys=["walkins"	=>"Walk-in Visitor",
							"legalaids"	=>"Counseling & Legal Advice",
							"incoming_calls"	=>"Incoming Call",
							"outgoing_calls"	=>"Outgoing Call",
							"legal_assistances"	=>"Legal Assistance",
							"cases"	=>"Court Cases",
							"sycop_calls"	=>"Sycop Calls"];
	private $forms=["Walk-in Visitor","Counseling & Legal Advice",
"Incoming Call","Outgoing Call","Legal Assistance",
"Court Cases","Sycop Calls"];
	private $result=[];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		

		$centers=retrieveField(Center::all(),'name');
		if(Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			$centers=[$center['id']=>$center['name']];
		}

		$forms=$this->forms;

		return View::make('layouts.reports.general')->with(compact('centers','forms'));

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function generalAnalysis(){

		$data=array(
			"months"=>array(
				array("1","January"),array("2","Feburary"),
				array("3","March"),array("4","April"),
				array("5","May"),array("6","June"),
				array("7","July"),array("8","August"),
				array("9","September"),array("10","October"),
				array("11","November"),array("12","December")
			),
			"years"=>array(
				"start"=>"2014", 
				"end"=>date("Y")
			),
			"table_headings"=>[]

		);

		return View::make('layouts.reports.general')->with(array("data"=>$data));
	}



	public function ajax_generalAnalysis(){

		$data=json_decode(Input::get('j'),true);
		$type=$data['range'];
		
		switch($type){

			case "weekly":

				$this->weekly($data);
				break;
			case 'monthly':

				$this->monthly($data);
				break;
			case 'quaterly':
				$this->quaterly($data);
				break;
			
			case 'yearly':
				$this->yearly($data);
				break;
			default:
				break;
		}
		
		$chart=$data['report']=='trend'?'line':'pie';

		return json_encode(['data'=>$this->result,'chart'=>$chart]);
	}


	public function slice_start($arr,$length){
		return array_slice($arr,$length,count($arr)-$length);
	}
				
				
	public function slice_end($arr,$length){
		return array_slice($arr,0,count($arr)-$length);
	}

	public function create_week_sets($start,$end){
		
		$items=[];
		$labels=[];					
		$outer_start=$start[2];
		$outer_end=$end[2];
		
		$inner_start=$start[1];
		$inner_end=$end[1];

		
		while($outer_start<=$outer_end){

			while($inner_start<=$inner_end){
			
				 
					$quaters=getWeeksDateRange($inner_start,$outer_start);				
					$items=array_merge($items,$quaters);	
					for($i=1;$i<=4;$i++){
						array_push($labels,'W'.$i.'-'.getMonthLabel($inner_start)."/$outer_start");
					}
				 

				$inner_start++;
			}

			$outer_start++;
		}
		
		$items=$this->slice_start($items,$start[0]-1);
		$items=$this->slice_end($items,4-$end[0]);

		$labels=$this->slice_start($labels,$start[0]-1);
		$labels==$this->slice_end($labels,4-$end[0]);
		// dd($items);
		return [$items,$labels];
	}


	public function create_month_sets($start,$end){
		
		$outer_start=$start[1];
		$outer_end=$end[1];
		
		$inner_start=$start[0];
		$inner_end=$end[0];

		$items=[];
		$labels=[];

		while($outer_start<=$outer_end){

			$quaters=getMonthsDateRange($outer_start);				
			$items=array_merge($items,$quaters);	
			for($i=1;$i<=12;$i++){

				array_push($labels,getMonthLabel($i).'-'."$outer_start");
			}

			$outer_start++;
		}

		$items=$this->slice_start($items,$start[0]-1);
		$items=$this->slice_end($items,12-$end[0]);

		$labels=$this->slice_start($labels,$start[0]-1);
		$labels==$this->slice_end($labels,12-$end[0]);
		// dd($items);
		return [$items,$labels];
	}


	public function create_quater_sets($start,$end){
		
		$outer_start=$start[1];
		$outer_end=$end[1];
		
		$inner_start=$start[0];
		$inner_end=$end[0];

		$items=[];
		$labels=[];
		
		while($outer_start<=$outer_end){

			$quaters=getQuatersDateRange($outer_start);				
			$items=array_merge($items,$quaters);	
			for($i=1;$i<=4;$i++){
				array_push($labels,'Q'.$i.'-'."$outer_start");
			}

			$outer_start++;
		}

		$items=$this->slice_start($items,$start[0]-1);
		$items=$this->slice_end($items,4-$end[0]);

		$labels=$this->slice_start($labels,$start[0]-1);
		$labels==$this->slice_end($labels,4-$end[0]);
		// dd($items);
		return [$items,$labels];
	}

	public function create_year_sets($start,$end){
		
		$outer_start=$start[0];
		$outer_end=$end[0];

		$items=[];
		$labels=[];
		
		while($outer_start<=$outer_end){

			$quaters=['01-01-'.$outer_start,'12-31-'.$outer_start];
			$items=array_merge($items,array($quaters));
            array_push($labels,"$outer_start");
			for($i=1;$i<=4;$i++){
			}
			/*$quaters=['01-01-'.$outer_start,'31-12-'.$outer_start];
			$items=array_merge($items,$quaters);
			for($i=1;$i<=4;$i++){
            array_push($labels,"$outer_start");
			}*/

			$outer_start++;
		}

		return [$items,$labels];

	}



	public function weekly($filters){

		if($filters['report']=='compare'){

			$items=[];
			$labels=[];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];


			$m=$filters['date']['from']['m'];
			$y=$filters['date']['from']['y'];
			$quaters=getWeeksDateRange($m,$y);
			array_push($items,$quaters[intval($filters['date']['from']['w'])-1]);
			array_push($labels,'W'.$filters['date']['from']['w'].'-'."$m/$y");

			$m=$filters['date']['to']['m'];
			$y=$filters['date']['to']['y'];
			$quaters=getWeeksDateRange($m,$y);
			array_push($items,$quaters[intval($filters['date']['to']['w'])-1]);
			array_push($labels,'W'.$filters['date']['to']['w'].'-'."$m/$y");

			for($i=0;$i<count($items);$i++) {
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}

			foreach ($this->result as $key => $value) {
			
				$keys=array_keys($value);
				$li=count($value)-1;
				
				$p=($value[$keys[0]]>0)?round(($value[$keys[$li]]-$value[$keys[0]])/$value[$keys[0]]*100,1):$value[$keys[$li]]*100;
				$this->result[$key]['Percentage Change']=$p.'%';
			}
			
		}
		else{

			$start=[intval($filters['date']['from']['w']),intval($filters['date']['from']['m']),intval($filters['date']['from']['y'])];
			$end=[intval($filters['date']['to']['w']),intval($filters['date']['to']['m']),intval($filters['date']['to']['y'])];
			$result=$this->create_week_sets($start,$end);
			$items=$result[0];
			$labels=$result[1];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];
			 
			for($i=0;$i<count($items);$i++){
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}
		}
	}

	public function monthly($filters){



		if($filters['report']=='compare'){

			$items=[];
			$labels=[];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];
			 
			$y=$filters['date']['from']['y'];
			$quaters=getMonthsDateRange($y);
			array_push($items,$quaters[intval($filters['date']['from']['m'])-1]);
			array_push($labels,'M'.$filters['date']['from']['m'].'-'.$y);

			$y=$filters['date']['to']['y'];
			$quaters=getMonthsDateRange($y);
			array_push($items,$quaters[intval($filters['date']['to']['m'])-1]);
			array_push($labels,'M'.$filters['date']['to']['m'].'-'.$y);

			for($i=0;$i<count($items);$i++) {
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}

			foreach ($this->result as $key => $value) {
			
				$keys=array_keys($value);
				$li=count($value)-1;
				
				$p=($value[$keys[0]]>0)?round(($value[$keys[$li]]-$value[$keys[0]])/$value[$keys[0]]*100,1):$value[$keys[$li]]*100;
				$this->result[$key]['Percentage Change']=$p.'%';
			}
			
		}
		else{

			$start=[intval($filters['date']['from']['m']),intval($filters['date']['from']['y'])];
			$end=[intval($filters['date']['to']['m']),intval($filters['date']['to']['y'])];
			$result=$this->create_month_sets($start,$end);
			$items=$result[0];
			$labels=$result[1];

			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];
		 
			for($i=0;$i<count($items);$i++){
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}
		}
	
	}

	public function quaterly($filters){

		if($filters['report']=='compare'){

			$items=[];
			$labels=[];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];

			$y=$filters['date']['from']['y'];
			$quaters=getQuatersDateRange($y);
			array_push($items,$quaters[intval($filters['date']['from']['q'])-1]);
			array_push($labels,'Q'.$filters['date']['from']['q'].'-'.$y);

			$y=$filters['date']['to']['y'];
			$quaters=getQuatersDateRange($y);
			array_push($items,$quaters[intval($filters['date']['to']['q'])-1]);
			array_push($labels,'Q'.$filters['date']['to']['q'].'-'.$y);

			for($i=0;$i<count($items);$i++) {
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}

			foreach ($this->result as $key => $value) {
			
				$keys=array_keys($value);
				$li=count($value)-1;
				
				$p=($value[$keys[0]]>0)?round(($value[$keys[$li]]-$value[$keys[0]])/$value[$keys[0]]*100,1):$value[$keys[$li]]*100;
				$this->result[$key]['Percentage Change']=$p.'%';
			}
			
		}
		else{

			$start=[intval($filters['date']['from']['q']),intval($filters['date']['from']['y'])];
			$end=[intval($filters['date']['to']['q']),intval($filters['date']['to']['y'])];
			$result=$this->create_quater_sets($start,$end);
			$items=$result[0];
			$labels=$result[1];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];
		
			for($i=0;$i<count($items);$i++){
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}
		}
	}

	public function yearly($filters){

		if($filters['report']=='compare'){

			$items=[];
			$labels=[];
			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];

			$y=$filters['date']['from']['y']; 
			array_push($items,['01-01-'.$y,'12-31-'.$y]);
			array_push($labels,$y);

			$y=$filters['date']['to']['y']; 
			array_push($items,['01-01-'.$y,'12-31-'.$y]);
			array_push($labels,$y);

            //echo "scucess";exit;
            //print_r($items) .'  '.print_r($labels);exit;
			for($i=0;$i<count($items);$i++) {
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}

			foreach ($this->result as $key => $value) {
			
				$keys=array_keys($value);
				$li=count($value)-1;
				
				$p=($value[$keys[0]]>0)?round(($value[$keys[$li]]-$value[$keys[0]])/$value[$keys[0]]*100,1):$value[$keys[$li]]*100;
				$this->result[$key]['Percentage Change']=$p.'%';
			}

            for($i=0;$i<count($items);$i++){

                $item=$items[$i];

                for($j=0;$j<count($tables);$j++) {

                    $t=$tables[$j];

                    $key=$this->result_keys[$t];
                    $label=$labels[$i];
                    /*if($t=='incoming_calls' || $t=='outgoing_calls'){ $first_follow_visit='call_type'; }else{ $first_follow_visit='first_follow_visit'; }
                    $this->result[$key][$label.' Male First Time ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array( 'gender'=>'Male', $first_follow_visit=>'First Time' ) ));
                    $this->result[$key][$label.' Female First Time ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Female', $first_follow_visit =>'First Time')));
                    $this->result[$key][$label.' Male Follow-up ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Male', $first_follow_visit=>'Follow-up')));
                    $this->result[$key][$label.' Female Follow-up ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Female', $first_follow_visit=>'Follow-up')));*/
                }
            }
			
		}
		else{

			$start=[intval($filters['date']['from']['y'])];
			$end=[intval($filters['date']['to']['y'])];
            //print_r($start) .'  '.print_r($end);exit;
			$result=$this->create_year_sets($start,$end);
			$items=$result[0];
			$labels=$result[1];

			$tables=intval($filters['form'])==-1?array_slice ($this->db_tables,0,count($this->db_tables)-1):[$this->db_tables[intval($filters['form'])]];
		
			for($i=0;$i<count($items);$i++){
				
				$item=$items[$i];

				for($j=0;$j<count($tables);$j++) {
				
					$t=$tables[$j];

					$key=$this->result_keys[$t];
					$label=$labels[$i];
					$this->result[$key][$label]=count(getRecordsByDate($t,[$item[0],$item[1]],$filters['center']));
				}
			}
            foreach ($this->result as $key => $value) {

                $keys=array_keys($value);
                $li=count($value)-1;

                $p=($value[$keys[0]]>0)?round(($value[$keys[$li]]-$value[$keys[0]])/$value[$keys[0]]*100,1):$value[$keys[$li]]*100;
                $this->result[$key]['Percentage Change']=$p.'%';
            }
            for($i=0;$i<count($items);$i++){

                $item=$items[$i];

                for($j=0;$j<count($tables);$j++) {

                    $t=$tables[$j];

                    $key=$this->result_keys[$t];
                    $label=$labels[$i];

                   /* if($t=='incoming_calls' || $t=='outgoing_calls'){ $first_follow_visit='call_type'; }else{ $first_follow_visit='first_follow_visit'; }
                    $this->result[$key][$label.' Male First Time ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array( 'gender'=>'Male', $first_follow_visit=>'First Time' ) ));
                    $this->result[$key][$label.' Female First Time ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Female', $first_follow_visit=>'First Time')));
                    $this->result[$key][$label.' Male Follow-up ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Male', $first_follow_visit=>'Follow-up')));
                    $this->result[$key][$label.' Female Follow-up ']=count(getRecordsByDateAndGender($t,[$item[0],$item[1]],$filters['center'], array('gender'=>'Female', $first_follow_visit=>'Follow-up')));*/
                }
            }
		}
	
	}

	public function download_pdf(){

		$data=json_decode(Input::get('json'),true);

		return create_pdf($data['html'],$data['title']);
	}

}
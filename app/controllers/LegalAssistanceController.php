<?php

class LegalAssistanceController extends \BaseController {

	
		public function pre_index(){


		/*$records=LegalAssistance::getAllRecords();
		$centers=retrieveField(Center::all(),'name');
		$decentrailzed_records=[];
		foreach ($centers as $key => $value) {
			$decentrailzed_records[$value]=0;
		}
		foreach ($records as $record){
			if(trim($record['center_id'])!=''){
				$decentrailzed_records[$record['center_id']]+=1;	
			}
		}*/
            $centers=retrieveField(Center::all(),'name');//old
            $decentrailzed_records=[];
            $total_count=0;
            foreach ($centers as $key => $value) {
                $center_count = \DB::table('legal_assistances')
                    ->where('center_id', '=', $key)
                    ->count();
                $decentrailzed_records[$value]=$center_count;
                $total_count+=$center_count;
            }
		$charts_data=[];
		foreach ($decentrailzed_records as $key => $value) {
			array_push($charts_data, [$key,$value]);
		}
		$data=[
			"heading"=>$this->heading,
			"records"=>$decentrailzed_records,
			"total"=>$total_count,
			"index_route"=>"legalassistance",
			"charts_data"=>json_encode($charts_data)
		];
		return View::make('layouts.records.pre_index')->with('data', $data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	private $heading="Legal Assistance";
	public function index()
	{
		$heading=$this->heading;
		$records=LegalAssistance::getLimitRecords(60);
		array_splice($records, 60);
		$display_fields=array('name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
		$labels=LegalAssistance::getLabels();
		$current_route_base='legalassistance';
        $table='legal_assistances';
        $ajaxi_used='ajaxi';
		$create_link='legalassistance.create';
		$iec_link='iec.index';
		$delete_link='legalassistance.delete';
		$excel_download_link='legalassistance.download_excel';
		$pdf_download_link='legalassistance.download_pdf';
		$report_download_link='legalassistance.download_report_pdf';
		$centers=array_values(retrieveField(Center::all(),'name'));
		sort( $centers );
		$report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact","address"),$labels),
					"centers"=>$centers);
		$has_reports=true;
		$small_form=false;
		$start_date=LegalAssistance::getStartDate();

		$data=array(

				'heading'=>$heading,
				'fields'=>$display_fields,
				'labels'=>$labels,
				'records'=>$records,
				'records_count'=>count($records),
                'table'=>$table,
                'ajaxi_used'=>$ajaxi_used,
                'current_route_base'=>$current_route_base,
				'create_link'=>$create_link,
				'iec_link'=>$iec_link,
				'delete_link'=>$delete_link,
				'excel_download_link'=>$excel_download_link,
				'pdf_download_link'=>$pdf_download_link,
				'report_download_link'=>$report_download_link,
				'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
				'has_reports'=>$has_reports,
				'small_form'=>$small_form,
				'group_analysis'=>'gprptleg',
				'start_date'=>$start_date
			);

		return View::make('layouts.records.index')->with('data', $data);
	}
    public function center($city)
    {
        //dd($city);
        $heading = $this->heading;
        $records = LegalAssistance::getCenterRecords($city);
        $display_fields=array('name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
        $labels=LegalAssistance::getLabels();
        $current_route_base='legalassistance';
        $table='legal_assistances';
        $ajaxi_used='center_ajaxi/'.$city;
        $create_link='legalassistance.create';
        $iec_link='iec.index';
        $delete_link='legalassistance.delete';
        $excel_download_link='legalassistance.download_excel';
        $pdf_download_link='legalassistance.download_pdf';
        $report_download_link='legalassistance.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact","center_id","address"),$labels),
            "centers"=>$centers);
        $has_reports=true;
        $small_form=false;
        $start_date=LegalAssistance::getStartDate();

        $data=array(

            'heading'=>$heading,
            'fields'=>$display_fields,
            'labels'=>$labels,
            'records'=>$records,
            'records_count'=>count($records),
            'current_route_base'=>$current_route_base,
            'table'=>$table,
            'ajaxi_used'=>$ajaxi_used,
            'create_link'=>$create_link,
            'iec_link'=>$iec_link,
            'delete_link'=>$delete_link,
            'excel_download_link'=>$excel_download_link,
            'pdf_download_link'=>$pdf_download_link,
            'report_download_link'=>$report_download_link,
            'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
            'has_reports'=>$has_reports,
            'small_form'=>$small_form,
            'group_analysis'=>'gprptleg',
            'start_date'=>$start_date
        );

        return View::make('layouts.records.index')->with('data', $data);
    }

    public function center_ajaxi($city)
    {
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        $records= \DB::table('legal_assistances')->where('center_id','=',$center->id)->get();
        $display_fields=array('id','name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
        $report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAssistance::getLabels()),
            "centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('LegalAssistance',$records,$display_fields);
        $records=array_slice($records,60);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		 $elements_data=$this->generate_form();
		 $data['elements_data']=$elements_data;
		 $data['can_import']=true;
		 $data['centers']=retrieveField(Center::all(),'name');
		 $data['submit_url']='legalassistance.store';
		 $data['upload_submit_url']='legalassistance.excel';
		 $data['heading']='Legal Assistance';
		 $data['go_back']='legalassistance.index';

		if(Auth::check() && Entrust::hasRole('Center_User')){
		 	$center=Confide::user()->center()->first();
		 	$data['centers']=[$center['id']=>$center['name']];
		}
		 return View::make('layouts.records.add')->with('data',$data);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$record=new LegalAssistance;
		$this->save_db($record,'LegalAssistances/create','Successfully created the record!');
		return Redirect::route('legalassistance.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record=LegalAssistance::find($id);	
		if(!$record){return;}

		$data['go_back']='legalassistance.index';
		$data['heading']='Legal Assistance';

		$labels=LegalAssistance::getLabels();
		foreach ($labels as $key => $value) {
			
			if(strpos($key, '_id')>0)
			{
				$func=str_replace("_id", "", $key);
				$tmp=$record->$func()->get()->toArray();
				$data['rows'][$value]=$tmp[0]['name'];
			}
			else{
				$data['rows'][$value]=$record->$key;	
			}
		}

		return View::make('layouts.records.detail')->with('data', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$record=LegalAssistance::find($id);
		$elements_data=$this->generate_form($record->toArray());
		$data['elements_data']=$elements_data;
		$data['can_import']=true;
		$data['centers']=retrieveField(Center::all(),'name');
		$data['submit_url']='legalassistance.update';
		$data['heading']='Legal Assistance';
		$data['go_back']='legalassistance.index';
		$data['record_id']=$record['id'];

		return View::make('layouts.records.edit')->with('data', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$record=LegalAssistance::find($id);
		$this->save_db($record,'legalassistance.edit','Successfully updated the record!');
		return Redirect::route('legalassistance.index');

	}

	public function excel(){
        $centers=retrieveField(Center::all(),'name');
		$center_id=Input::get('center_id');
		$extension = Input::file('file')->getClientOriginalExtension();
		$fileName=microtime().'.'.$extension;
		Input::file('file')->move(__DIR__.'/storage/dump/',$fileName);
        if($center_id=='')
        {
            $field_count= 28;
        }
        else{
            $field_count=27;
        }
		$rows=getExcelAllRows(__DIR__.'/storage/dump/'.$fileName,$field_count);
		$rows=array_slice($rows, 4);
		foreach ($rows as $row) {
			$is_empty=trim(implode("",$row));
			if($is_empty  !=""){
				array_shift($row);
				$t1=(PriorityGroup::firstOrCreate(array('name'=>$row[12])));
				$t2=(MinorityGroup::firstOrCreate(array('name'=>$row[13])));
				$t3=(ProblemNature::firstOrCreate(array('name'=>$row[15])));
				$row[12]=$t1->id;
				$row[13]=$t2->id;
				$row[15]=$t3->id;
				$row[20]=transform_date($row[20]);
                if($center_id=='')
                {
                    foreach ($centers as $cen_key=>$cen_val)
                    {
                        if($cen_val==$row[26])
                        {
                            $row[26] = $cen_key;
                        }
                    }
                }
                else{
                    array_push($row, $center_id);
                }
				$row=mapArrays(LegalAssistance::getFillables(),$row);
				// print_r($row);
				str_replace(",", "%2C", $row);
				LegalAssistance::create($row);
 			}
		}

		Session::flash('message', 'All records has been imported');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('legalassistance.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		LegalAssistance::destroy($id);

		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('legalassistance.index');
	}


	public function save_db($record,$error_redirect,$success_msg){

		$fields=LegalAssistance::getFillables();
		$rules=array();

		foreach ($fields as $field) {
			$rules[$field]='required';
		}


		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			// get the error messages from the validator
			$messages = $validator->messages();

			Session::flash('message', $messages->all());
			Session::flash('alert-class', 'alert-danger'); 
			return Redirect::route($error_redirect);

		} else {

			$inputs=Input::all();
			$inputs['date']=transform_date(Input::get('date'));
			foreach ($fields as $field) {	
				$record->$field=$inputs[$field];
			}
			$record->save();

			Session::flash('message', $success_msg);
			Session::flash('alert-class', 'alert-success'); 
			
		}
	}

	public function generate_form($values=array()){

		//$a=retrieveField(PriorityGroup::all(),'name');
		//$b=retrieveField(MinorityGroup::all(),'name');
        ////'GBV','Person With Disabillity','Minority','Other'
        /*$a = array();
        $a[2] = "GBV";
        $a[3] = "Persons With disabilities";
        $a[6] = "Minorities";
        $a[1] = "Others";*/
        $Priority_array= array();
        $records= \DB::table('priority_groups')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $Priority_array[$record->id] = $record->name;
        }
        $a= $Priority_array;


        //'Christian', 'Hindo', 'Sikh', 'Hazara', 'Ahmadi'/* $b[14] = "Muslim";*/
        /*$b=array();
        $b[24] = "N.A";
        $b[2] = "Christian";
        $b[17] = "Hindu";
        $b[51] = "Sikh";
        $b[15] = "Hazara";
        $b[37] = "Ahmadi";*/
        $MinorityGroup_array= array();
        $records= \DB::table('minority_groups')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $MinorityGroup_array[$record->id] = $record->name;
        }
        $b= $MinorityGroup_array;



		//$c=retrieveField(ProblemNature::all(),'name');
        $problem_natures_array= array();
        $records= \DB::table('problem_natures')->where('status','=','show')->orderBy('name', 'asc')->get();
        //echo "<pre>";dd($records);
        foreach ($records as $record)
        {
            $problem_natures_array[$record->id] = $record->name;
        }
        $c= $problem_natures_array;




        $d=retrieveField(Center::all(),'name');

		$options=array(
			'gender'=>getGenderOptions(),
			'priority_group_id'=>$a,
			'minority_group_id'=>$b,
			'marital_status'=>getMaritalStatusOptions(),
			'problem_nature_id'=>$c,
			'stage_proceeding'=>getStageProceedingOptions(),
			'psychosocial_support'  => getPyscoSupportOptions(),
			'center_id'=>$d,
			'decision_result'=>array(
				"-"=>"-",
				"Successful"=>"Successful",
				"Unsuccessful"=>"Unsuccessful"
			)
		);
		if(Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
		 	$options['center_id']=[$center['id']=>$center['name']];
		}
		$labels=LegalAssistance::getLabels();
		$elements_data=array();

		foreach ($labels as $key => $value) {
			
			if(isset($options[$key])){

				$arr=array(
						"tag"=>"select","name"=>$key,
						"value"=>"","options"=>$options[$key]
				);	
			}
			else{

				$arr=array(
						"tag"=>"input","name"=>$key,
						"value"=>"","type"=>"text"
				);	
			}

			$elements_data[$value]=$arr;
		}


        //Nature Of Problem
        $case_natures_array= array();
        $problem_natures_groups = DB::table('problem_natures')->where( 'status', '=', 'show')->groupBy('problemgroup')->get();
        foreach ($problem_natures_groups as $group)
        {
            if($group->problemgroup !='')
            {
                $groups_records = \DB::table('problem_natures')->select('id','name')->where('problemgroup','=',$group->problemgroup)->get();
                $myarray=array();
                foreach ($groups_records as $record)
                {
                    $myarray[$record->id] = $record->name;
                }
                $case_natures_array[$group->problemgroup] = $myarray;
            }
        }
        $elements_data['Nature Of Problem']=array(
            "tag"=>"select_options","name"=>'problem_nature_id',
            "value"=>"","options"=>$case_natures_array);


		if(count($values)==0) return $elements_data;
		 
		$new_elements_data=array();

		foreach ($elements_data as $key => $array) {
			
			$k=$array['name'];

			if(isset($values[$k])){

				$array['value']=$values[$k];
				$new_elements_data[$key]=$array;
			}
		}

		return $new_elements_data;
	}


	public function download_excel(){

		$ids=explode(",",Input::get('ids'));
		$records=LegalAssistance::getAllRecordsByIds($ids);
		if(count($records)<1){return;}

		$rows=array();
		$headings=array();
		foreach ($records[0] as $key => $value) {
			array_push($headings,$key);
		}

		array_push($rows,$headings);
		$rows=array_merge($rows,$records);

		$file=createExcel(array("name"=>$this->heading),$rows,21);
		return json_encode(array("path"=>$file));
	}

	public function download_pdf(){
		
		$ids=explode(",",Input::get('ids'));
		$records=LegalAssistance::getAllRecordsByIds($ids,array('name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id'));
		
		if(count($records)<1){return;}

		$rows=array();
		$headings=array();
		foreach ($records[0] as $key => $value) {
			array_push($headings,$key);
		}

		$data=array("heading"=>"Legal Assistance","headings"=>$headings,"records"=>$records);

		$html=View::make('layouts.pdf.record',array('data'=>$data));
		$file=create_pdf($html,'Legal Assistance',true);
		return json_encode(array("path"=>$file));
	}

	public function download_report_pdf(){

		$data=json_decode(Input::get('json'),true);

		foreach ($data as $key => $value) {
			$value['html']=html_entity_decode($value['html'],ENT_COMPAT, 'UTF-8');
		}

		$html=View::make('layouts.pdf.report',array('data'=>$data));
		echo $html;	exit();
		return create_pdf($html,'Legal Assistance');
	}

	public function ajax(){
		//01/27/2015
		$start=explode('/',Input::get('from'));
		$end=explode('/',Input::get('to'));

		$start=$start[2].'-'.$start[0].'-'.$start[1];
		$end=$end[2].'-'.$end[0].'-'.$end[1];

		//$records=getRecordsByDate('legal_assistances',[$start,$end]);
        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $records=getRecordsByDate('legal_assistances',[$start,$end],$center->id);
        }else{
            $records=getRecordsByDate('legal_assistances',[$start,$end]);
        }

		$display_fields=array('id','name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
		$report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact"),LegalAssistance::getLabels()),
					"centers"=>array_values(retrieveField(Center::all(),'name')));

		$records=filterFields('LegalAssistance',$records,$display_fields);

		return json_encode(['records'=>$records,'report_data'=>$report_data]);
	}

    public function center_ajax($city){
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));

        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];

        $records=getRecordsByDate('legal_assistances',[$start,$end], $center->id);

        $display_fields=array('id','name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
        $report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAssistance::getLabels()),
            "centers"=>array_values(retrieveField(Center::all(),'name')));

        $records=filterFields('LegalAssistance',$records,$display_fields);

        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }
	public function ajaxi(){
		 

		$records=[];
		if(Auth::check() && Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			 
			$records=LegalAssistance::where('center_id','=',$center->id)->get();
		}else{
			$records=LegalAssistance::get();
		}

		$display_fields=array('id','name','gender','priority_group_id','minority_group_id','problem_nature_id','institution','date','decision_date','decision_result','center_id');
		$report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","contact"),LegalAssistance::getLabels()),
					"centers"=>array_values(retrieveField(Center::all(),'name')));

		$records=filterFields('LegalAssistance',$records,$display_fields);
		$records=array_slice($records,60);
		return json_encode(['records'=>$records,'report_data'=>$report_data]);
	}

}
?>
<?php

class SycopCallsController extends \BaseController {

	private $heading="SYCOP Calls";

	public function pre_index(){

		
		$records=SycopCall::getAllRecords();
		$centers=retrieveField(Center::all(),'name');
		$decentrailzed_records=[];

		foreach ($centers as $key => $value) {
			$decentrailzed_records[$value]=0;
		}

		foreach ($records as $record) {
			if(trim($record['center_id'])!=''){
				$decentrailzed_records[$record['center_id']]+=1;	
			}	

		}

		$charts_data=[];

		foreach ($decentrailzed_records as $key => $value) {
			
			array_push($charts_data, [$key,$value]);
		}


		$data=[
			"heading"=>$this->heading,
			"records"=>$decentrailzed_records,
			"total"=>count($records),
			"index_route"=>"sycop",
			"charts_data"=>json_encode($charts_data)
		];


		return View::make('layouts.records.pre_index')->with('data', $data);
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response

	public function index()
	{
		$heading=$this->heading;
		$records=SycopCall::getLimitRecords(20);
array_splice($records, 20);
		$display_fields=array('name','date','first_follow','gender','caller_district','priority_group',
'callback','refered_to',"center_id");
		
		$labels=SycopCall::getLabels();
		$current_route_base='sycop';
        $table='sycop_calls';
        $ajaxi_used='ajaxi';
		$create_link='sycop.create';
		$iec_link='iec.index';
		$delete_link='sycop.delete';
		$excel_download_link='sycop.download_excel';
		$pdf_download_link='sycop.download_pdf';
		$report_download_link='sycop.download_report_pdf';
		$centers=array_values(retrieveField(Center::all(),'name'));
		sort( $centers );
		$report_data=array("center_column"=>11,"reports_exception"=>getValues(array("name","date"),$labels),
					"centers"=>$centers);

		$has_reports=true;
		$small_form=false;
		$start_date=SycopCall::getStartDate();

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
				'start_date'=>$start_date
                'class'=>'sycop'
			);

		return View::make('layouts.records.index')->with('data', $data);
	}*/
    public function index()
    {
        $heading=$this->heading;
        $records=SycopCall::getLimitRecords(60);
        array_splice($records, 60);
        $display_fields=array('name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");

        $labels=SycopCall::getLabels();
        $current_route_base='sycop';
        $table='sycop_calls';
        $ajaxi_used='ajaxi';
        $create_link='sycop.create';
        $iec_link='iec.index';
        $delete_link='sycop.delete';
        $excel_download_link='sycop.download_excel';
        $pdf_download_link='sycop.download_pdf';
        $report_download_link='sycop.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>9,"reports_exception"=>getValues( array("name","date"),$labels ),
            "centers"=>$centers);
        $has_reports=true;
        $small_form=false;
        $start_date=SycopCall::getStartDate();
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
            'start_date'=>$start_date,
            'class'=>'sycop'
        );
        return View::make('layouts.records.index')->with('data', $data);
    }
    public function center($city)
    {
        $heading = $this->heading;
        $records = SycopCall::getCenterRecords($city);
        array_splice($records, 60);
        $display_fields=array('name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");

        $labels=SycopCall::getLabels();
        $current_route_base='sycop';
        $table='sycop_calls';
        $ajaxi_used='center_ajaxi/'.$city;
        $create_link='sycop.create';
        $iec_link='iec.index';
        $delete_link='sycop.delete';
        $excel_download_link='sycop.download_excel';
        $pdf_download_link='sycop.download_pdf';
        $report_download_link='sycop.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","date"),$labels),
            "centers"=>$centers);

        $has_reports=true;
        $small_form=false;
        $start_date=SycopCall::getStartDate();

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
            'start_date'=>$start_date,
            'class'=>'sycop'
        );



        return View::make('layouts.records.index')->with('data', $data);
    }
    public function center_ajaxi($city)
    {
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        $records = \DB::table('sycop_calls')->where('center_id', '=', $center->id)->get();
        $display_fields = array('id', 'name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", "date"),
            SycopCall::getLabels()), "centers" => array_values(retrieveField(Center::all(), 'name')));

        $records = filterFields('SycopCall', $records, $display_fields);
        $records = array_slice($records, 60);

        return json_encode(['records' => $records, 'report_data' => $report_data]);
    }
    public function center_ajax($city){
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));
        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];
        $records=getRecordsByDate('sycop_calls',[$start,$end], $center->id);
        // var_dump($records);exit;
        $display_fields=array('id', 'name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");
        $report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","date"),
            SycopCall::getLabels()),"centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('SycopCall',$records,$display_fields);
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
		 $data['submit_url']='sycop.store';
		 $data['upload_submit_url']='sycop.excel';
		 $data['heading']='Sycop Calls';
		 $data['go_back']='sycop.index';

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
		
		$record=new SycopCall;
		$this->save_db($record,'sycop.create','Successfully created the record!');
		return Redirect::route('sycop.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record=SycopCall::find($id);	
		if(!$record){return;}

		$data['go_back']='sycop.index';
		$data['heading']='Sycop Calls';

		$labels=SycopCall::getLabels();
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

		$record=SycopCall::find($id);
		$elements_data=$this->generate_form($record->toArray());
		$data['elements_data']=$elements_data;
		$data['can_import']=true;
		$data['centers']=retrieveField(Center::all(),'name');
		$data['submit_url']='sycop.update';
		$data['heading']='Sycop Calls';
		$data['go_back']='sycop.index';
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
		
		$record=SycopCall::find($id);
		$this->save_db($record,'sycop.edit','Successfully updated the record!');
		return Redirect::route('sycop.index');

	}

	public function excel(){

		$center_id=Input::get('center_id');

		$extension = Input::file('file')->getClientOriginalExtension();
		$fileName=microtime().'.'.$extension;
		Input::file('file')->move(__DIR__.'/storage/dump/',$fileName);
		$rows=getExcelAllRows(__DIR__.'/storage/dump/'.$fileName,13);
		$rows=array_slice($rows, 4);
		 
		foreach ($rows as $row) {
			
			$is_empty=trim(implode("",$row));
			

			if($is_empty!=""){

				array_shift($row);
				array_push($row, $center_id);
				
				$row[1]=transform_date($row[1]);
				$row=mapArrays(SycopCall::getFillables(),$row);
				str_replace(",", "%2C", $row);
				SycopCall::create($row);
			}
		}

		Session::flash('message', 'All records has been imported');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('sycop.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		SycopCall::destroy($id);

		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('sycop.index');
	}


	public function save_db($record,$error_redirect,$success_msg){

		$fields=SycopCall::getFillables();
		$rules=array();

		foreach ($fields as $field) {
			$rules[$field]='required';
		}


		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
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

		$a=retrieveField(Center::all(),'name');
		//$b=retrieveField(PriorityGroup::all(),'name');
        $Priority_array= array();
        $records= \DB::table('priority_groups')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $Priority_array[$record->id] = $record->name;
        }
        $b= $Priority_array;

        $refers_array= array();
        $refers= \DB::table('centers')->get();
        foreach ($refers as $refer)
        {
            $refers_array[$refer->name] = $refer->name;
        }

		$n_b= array();
		foreach ($b as $key => $value) {
			$n_b[$value]=$value;
		}
		$b=$n_b;
 
		$options=array(

			'gender'=>getGenderOptions(),
			'first_follow'=>getVisistTime(),
			'priority_group'=>$b,
            'refered_to'=>$refers_array,
			'center_id'=>$a
		);

		if(Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
		 	$options['center_id']=[$center['id']=>$center['name']];
		}

		$labels=SycopCall::getLabels();
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

		// dd($values);
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
		$records=SycopCall::getAllRecordsByIds($ids);
		if(count($records)<1){return;}

		$rows=array();
		$headings=array();
		foreach ($records[0] as $key => $value) {
			array_push($headings,$key);
		}

		array_push($rows,$headings);
		$rows=array_merge($rows,$records);

		$file=createExcel(array("name"=>$this->heading),$rows,2);
			 
		return json_encode(array("path"=>$file));

	}

	public function download_pdf(){
		
		$ids=explode(",",Input::get('ids'));
		$records=SycopCall::getAllRecordsByIds($ids,array('name','date','first_follow','gender','caller_district','priority_group',
'callback','refered_from','refered_to','refer','staff_name',"center_id"));
		if(count($records)<1){return;}

		$rows=array();
		$headings=array();
		foreach ($records[0] as $key => $value) {
			array_push($headings,$key);
		}

		$data=array("heading"=>"Sycop Calls","headings"=>$headings,"records"=>$records);

		$html=View::make('layouts.pdf.record',array('data'=>$data));
		return create_pdf($html,'Sycop Calls',true);
	}

	public function download_report_pdf(){

		$data=json_decode(Input::get('json'),true);
		foreach ($data as $key => $value) {
			$value['html']=html_entity_decode($value['html'],ENT_COMPAT, 'UTF-8');
		}

		$html=View::make('layouts.pdf.report',array('data'=>$data));
		$file= create_pdf($html,'SYCOP Calls');
		return json_encode(array("path"=>$file));
	}

	public function ajax(){
		//01/27/2015
		$start=explode('/',Input::get('from'));
		$end=explode('/',Input::get('to'));

		$start=$start[2].'-'.$start[0].'-'.$start[1];
		$end=$end[2].'-'.$end[0].'-'.$end[1];

		$records=getRecordsByDate('sycop_calls',[$start,$end]);
		// var_dump($records);exit;

		$display_fields=array('id', 'name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");

		$report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","date"),
					SycopCall::getLabels()),"centers"=>array_values(retrieveField(Center::all(),'name')));

		$records=filterFields('SycopCall',$records,$display_fields);

		return json_encode(['records'=>$records,'report_data'=>$report_data]);
	}
	
	
	public function ajaxi(){
		 

		$records=[];
		if(Auth::check() && Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			 
			$records=SycopCall::where('center_id','=',$center->id)->get();
		}else{
			$records=SycopCall::get();
		}
		// var_dump($records);exit;

		$display_fields=array('id', 'name','date','first_follow','gender','caller_district','priority_group',
            'callback','refered_to',"center_id");

		$report_data=array("center_column"=>9,"reports_exception"=>getValues(array("name","date"),
					SycopCall::getLabels()),"centers"=>array_values(retrieveField(Center::all(),'name')));

		$records=filterFields('SycopCall',$records,$display_fields);
		$records=array_slice($records,60);
		
		return json_encode(['records'=>$records,'report_data'=>$report_data]);
	}
}
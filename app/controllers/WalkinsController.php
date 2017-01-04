<?php
class WalkinsController extends \BaseController {
	private $heading="Walkin Clients";
	public function pre_index(){
		/*$records=Walkin::getAllRecords();
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
		*/
        $centers=retrieveField(Center::all(),'name');//old
        $decentrailzed_records=[];
        //$total_count=0;
        foreach ($centers as $key => $value) {
            $center_count = \DB::table('walkins')
                ->where('center_id', '=', $key)
                ->count();
            $decentrailzed_records[$value]=$center_count;
           // $total_count+=$center_count;
        }
        $total_count = \DB::table('walkins')->count();
        $charts_data=[];
        foreach ($decentrailzed_records as $key => $value) {
            array_push($charts_data, [$key,$value]);
        }
		$data=[
			"heading"=>$this->heading,
			"records"=>$decentrailzed_records,
			"total"=>$total_count,
			"index_route"=>"walkin",
			"charts_data"=>json_encode($charts_data)
		];
		return View::make('layouts.records.pre_index')->with('data', $data);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$heading=$this->heading;
		$records=Walkin::getLimitRecords(60);
        array_splice($records, 60);
		$display_fields=array('name','first_follow_visit','gender','visit_reason','date','heard_from','center_id');
		
		$labels=Walkin::getLabels();
		$current_route_base='walkin';
        $table='walkins';
        $ajaxi_used='ajaxi';
		$create_link='walkin.create';
        $iec_link='iec.index';
		$delete_link='walkin.delete';
		$excel_download_link='walkin.download_excel';
		$pdf_download_link='walkin.download_pdf';
		$report_download_link='walkin.download_report_pdf';
		$centers=array_values(retrieveField(Center::all(),'name'));
		sort( $centers );
		$report_data=array("center_column"=>6,"reports_exception"=>getValues(array("name","date","center_id"),$labels),"fof"=>1,"fofs"=>[2,-1,1,-1],
					"centers"=>$centers);
        //echo "<pre>";print_r($report_data);exit;
		$has_reports=true;
		$small_form=false;
		$start_date=Walkin::getStartDate();
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
                'class'=>'walkin'
			);
		return View::make('layouts.records.index')->with('data', $data);
	}
    public function center($city)
    {
        $heading=$this->heading;
        $records=Walkin::getCenterRecords($city);
        array_splice($records, 60);
        $display_fields=array('name','first_follow_visit','gender','visit_reason','date','heard_from','center_id');
        $labels=Walkin::getLabels();
        $current_route_base='walkin';
        $table='walkins';
        $create_link='walkin.create';
        $iec_link='iec.index';
        $ajaxi_used='center_ajaxi/'.$city;
        $delete_link='walkin.delete';
        $excel_download_link='walkin.download_excel';
        $pdf_download_link='walkin.download_pdf';
        $report_download_link='walkin.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>6,"reports_exception"=>getValues(array("name","date","center_id"),$labels),"fof"=>1,"fofs"=>[2,-1,1,-1],
            "centers"=>$centers);
        $has_reports=true;
        $small_form=false;
        $start_date=Walkin::getStartDate();
        $data=array(
            'heading'               =>  $heading,
            'fields'                =>  $display_fields,
            'labels'                =>  $labels,
            'records'               =>  $records,
            'records_count'         =>  count($records),
            'current_route_base'    =>  $current_route_base,
            'table'                 =>  $table,
            'ajaxi_used'            =>  $ajaxi_used,
            'create_link'           =>  $create_link,
            'iec_link'              =>  $iec_link,
            'delete_link'           =>  $delete_link,
            'excel_download_link'   =>  $excel_download_link,
            'pdf_download_link'     =>  $pdf_download_link,
            'report_download_link'  =>  $report_download_link,
            'report_data'           =>  json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
            'has_reports'           =>  $has_reports,
            'small_form'            =>  $small_form,
            'start_date'            =>  $start_date,
            'class'                 =>  'walkin'
        );
        return View::make('layouts.records.index')->with('data', $data);
    }
    public function center_ajaxi($city)
    {
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        $records= \DB::table('walkins')->where('center_id','=',$center->id)->get();
        $display_fields=array('id','name','first_follow_visit','gender','visit_reason','date','heard_from','center_id');
        $report_data=array("center_column"=>6, "reports_exception"=>getValues(array("name", "date","center_id"),
        Walkin::getLabels()),"fof"=>1, "fofs"=>[2,-1,1,-1], "centers"=>array_values(retrieveField(Center::all(), 'name')));
        $records=filterFields('Walkin',$records,$display_fields);
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
		 $data['submit_url']='walkin.store';
		 $data['upload_submit_url']='walkin.excel';
		 $data['heading']='Walkin Clients';
		 $data['go_back']='walkin.index';
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
		
		$record=new Walkin;
		$this->save_db($record,'walkin.create','Successfully created the record!');
		return Redirect::route('walkin.index');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record=Walkin::find($id);	
		if(!$record){return;}
		$data['go_back']='walkin.index';
		$data['heading']='Walkin Clients';
		$labels=Walkin::getLabels();
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
		$record=Walkin::find($id);
		$elements_data=$this->generate_form($record->toArray());
		$data['elements_data']=$elements_data;
		$data['can_import']=true;
		$data['centers']=retrieveField(Center::all(),'name');
		$data['submit_url']='walkin.update';
		$data['heading']='Walkin Clients';
		$data['go_back']='walkin.index';
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
		
		$record=Walkin::find($id);
		$this->save_db($record,'walkin.edit','Successfully updated the record!');
		return Redirect::route('walkin.index');
	}
	public function excel(){
        $centers=retrieveField(Center::all(),'name');
		$center_id=Input::get('center_id');
		$extension = Input::file('file')->getClientOriginalExtension();
		$fileName=microtime().'.'.$extension;
		Input::file('file')->move(__DIR__.'/storage/dump/',$fileName);
        if($center_id=='')
        {
            $field_count= 16;
        }
        else{
            $field_count=15;
        }
		$rows=getExcelAllRows(__DIR__.'/storage/dump/'.$fileName,$field_count);
		$rows=array_slice($rows, 4);
		foreach ($rows as $row) {
            $is_empty=trim(implode("",$row));
            if($is_empty!=""){
                array_shift($row);
                if($center_id=='')
                {
                    foreach ($centers as $cen_key=>$cen_val)
                    {
                        if($cen_val==$row[14])
                        {
                            $row[14] = $cen_key;
                        }
                    }
                }
                else{
                    array_push($row, $center_id);
                }
                $row[1]=transform_date($row[1]);
                $row=mapArrays(Walkin::getFillables(),$row);
                str_replace(",", "%2C", $row);
                Walkin::create($row);
            }
        }
		Session::flash('message', 'All records has been imported');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('walkin.index');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Walkin::destroy($id);
		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('walkin.index');
	}
	public function save_db($record,$error_redirect,$success_msg){
		$fields=Walkin::getFillables();
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
        $heard_abouts_array= array();
        $records= \DB::table('heard_abouts')->get();
        foreach ($records as $record)
        {
            $heard_abouts_array[$record->name] = $record->name;
        }
        $g= $heard_abouts_array;
		$options=array(
			'gender'=>getGenderOptions(),
			'first_follow_visit'=>getVisistTime(),
			'visit_type'=>getVisistType(),
			'visit_reason'=>getVisistReason(),
			'center_id'=>$a,
			'heard_from'=>$g
		);
		if(Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
		 	$options['center_id']=[$center['id']=>$center['name']];
		}
		$labels=Walkin::getLabels();
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
		
		$records=Walkin::getAllRecordsByIds($ids);
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
		$records=Walkin::getAllRecordsByIds($ids,array('name','first_follow_visit','gender','visit_reason'
							,'visit_type','date','heard_from','center_id'));
		
		if(count($records)<1){return;}
		$rows=array();
		$headings=array();
		foreach ($records[0] as $key => $value) {
			array_push($headings,$key);
		}
		$data=array("heading"=>"Walkin Clients","headings"=>$headings,"records"=>$records);
		$html=View::make('layouts.pdf.record',array('data'=>$data));
		 // return $html;
		$file= create_pdf($html,'Walkin Clients',true);
		return json_encode(array("path"=>$file));
	}
	public function download_report_pdf(){
		$data=json_decode(Input::get('json'),true);
		
		foreach ($data as $key => $value) {
			$value['html']=html_entity_decode($value['html'],ENT_COMPAT, 'UTF-8');
		}
		$html=View::make('layouts.pdf.report',array('data'=>$data));
		 
		return create_pdf($html,'Walkin Clients');
	}
    public function ajax(){
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));
        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];
        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $records=getRecordsByDate('walkins',[$start,$end],$center->id);
        }else{
            $records=getRecordsByDate('walkins',[$start,$end]);
        }

        $display_fields=array('id','name','first_follow_visit','gender','visit_reason'
        ,'date','heard_from','center_id');
        $report_data=array("center_column"=>6,"reports_exception"=>getValues(array("name","date","center_id"),
            Walkin::getLabels()),"fof"=>1,"fofs"=>[2,-1,1,-1],"centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('Walkin',$records,$display_fields);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }
    public function center_ajax($city){
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));
        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];
        $records=getRecordsByDate('walkins', [$start,$end], $center->id);
        $display_fields=array('id','name','first_follow_visit','gender','visit_reason'
        ,'date','heard_from','center_id');
        $report_data=array("center_column"=>6,"reports_exception"=>getValues(array("name","date","center_id"),
            Walkin::getLabels()),"fof"=>1,"fofs"=>[2,-1,1,-1],"centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('Walkin',$records,$display_fields);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }
	
	public function ajaxi(){
		$records=[];
		if(Auth::check() && Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			$records=Walkin::where('center_id','=',$center->id)->get();
		}else{
			$records=Walkin::get();
		}
		$display_fields=array('id','name','first_follow_visit','gender','visit_reason'
							,'date','heard_from','center_id');
		$report_data=array("center_column"=>6,"reports_exception"=>getValues(array("name","date","center_id"),
					Walkin::getLabels()),"fof"=>1,"fofs"=>[2,-1,1,-1],"centers"=>array_values(retrieveField(Center::all(),'name')));
		$records=filterFields('Walkin',$records,$display_fields);
		$records=array_slice($records,60);
		return json_encode(['records'=>$records,'report_data'=>$report_data]);
	}
    public function multiple_delet(){
        if(isset($_POST['ids']))
        {
            print_r($_POST['ids']);
            foreach($_POST['ids'] as $id)
            {
                \DB::table($_POST['table'])->where('id', '=', $id)->delete();
            }
        }
    }
}
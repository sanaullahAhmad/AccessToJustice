<?php

class PriorityGroupsController extends \BaseController {

	private $heading="Priority Groups";

	public function index()
	{
		$heading=$this->heading;
		$records=PriorityGroup::getAllRecords();
		$display_fields=array('name','status');
		$labels=PriorityGroup::getLabels();
		$current_route_base='priority';
		$create_link='priority.create';
		$iec_link='';
		$delete_link='priority.delete';
		$excel_download_link='';
		$pdf_download_link='';
		$report_download_link='';
		$report_data=array();
		$has_reports=false;
		$small_form=true;

		$data=array(

				'heading'=>$heading,
				'fields'=>$display_fields,
				'labels'=>$labels,
				'records'=>$records,
				'records_count'=>count($records),
				'current_route_base'=>$current_route_base,
            'table'=>'priority_groups',
            'ajaxi_used'=>'ajaxi',
				'create_link'=>$create_link,
				'iec_link'=>$iec_link,
				'delete_link'=>$delete_link,
				'excel_download_link'=>$excel_download_link,
				'pdf_download_link'=>$pdf_download_link,
				'report_download_link'=>$report_download_link,
				'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
				'has_reports'=>$has_reports,
				'small_form'=>$small_form
			);

		return View::make('layouts.records.index')->with('data', $data);
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
		 $data['can_import']=false;
		 $data['centers']=array();
		 $data['submit_url']='priority.store';
		 $data['upload_submit_url']='priority.excel';
		 $data['heading']=$this->heading;
		 $data['go_back']='priority.index';

		 return View::make('layouts.records.add')->with('data',$data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$record=new PriorityGroup;
		$this->save_db($record,'PriorityGroups/create','Successfully created the record!');
		return Redirect::route('priority.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record=PriorityGroup::find($id);	
		if(!$record){return;}

		$data['go_back']='priority.index';
		$data['heading']=$this->heading;

		$labels=PriorityGroup::getLabels();
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

		$record=PriorityGroup::find($id);
		$elements_data=$this->generate_form($record->toArray());
		$data['elements_data']=$elements_data;
		$data['can_import']=true;
		$data['centers']=retrieveField(Center::all(),'name');
		$data['submit_url']='priority.update';
		$data['heading']=$this->heading;
		$data['go_back']='priority.index';
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
		
		$record=PriorityGroup::find($id);
		$this->save_db($record,'priority.edit','Successfully updated the record!');
		return Redirect::route('priority.index');

	}


		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		PriorityGroup::destroy($id);

		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('priority.index');
	}


	public function save_db($record,$error_redirect,$success_msg){

		$fields=PriorityGroup::getFillables();
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


			foreach ($fields as $field) {	
				$record->$field=Input::get($field);
			}
			$record->save();

			Session::flash('message', $success_msg);
			Session::flash('alert-class', 'alert-success'); 
			
		}
	}

	public function generate_form($values=array()){

		$options=array(
            'status'=>array('show'=>'show', 'dont show'=>'dont show')
		);

		$labels=PriorityGroup::getLabels();
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

}

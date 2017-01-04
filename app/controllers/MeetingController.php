<?php

class MeetingController extends \BaseController {

	private $heading="Coordination Meetings";

	public function index()
	{
		
	
			
		$meetings=Meeting::getAllRecords();
		 
		return View::make('layouts.meeting.index')->with('meetings', $meetings);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

			$data=array(
				'districts'=>retrieveField(District::all(),'name'),
			);
		return View::make('layouts.meeting.add')->with('data', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$d=Input::get('district');
		$date=Input::get('date');
		$quater=Input::get('quater');
		$org=json_decode(Input::get('org'),true);
		
		$record=new Meeting;
		$record->date=$date;
		$record->quater=$quater;
		$record->district_id=intval($d);
		$record->rightbased_org=(json_encode($org['rb']));
		$record->goveronment_deps=(json_encode($org['gd']));
		$record->political_personalities=(json_encode($org['pp']));
		$record->social_activists=(json_encode($org['sa']));
		$record->district_bar=(json_encode($org['db']));
		$record->save();
		return 'ok';
		//return Redirect::route('meeting.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		 
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$record=Meeting::getAllRecordsByIds([$id]);

		return View::make('layouts.meeting.edit')->with(['districts'=>retrieveField(District::all(),'name'),'meeting'=>$record[0]]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$record=Meeting::find($id);
		 
		$d=Input::get('district');
		$date=Input::get('date');
		$quater=Input::get('quater');
		$org=json_decode(Input::get('org'),true);
		$record->date=$date;
		$record->quater=$quater;
		$record->district_id=intval($d);
		$record->rightbased_org=(json_encode($org['rb']));
		$record->goveronment_deps=(json_encode($org['gd']));
		$record->political_personalities=(json_encode($org['pp']));
		$record->social_activists=(json_encode($org['sa']));
		$record->district_bar=(json_encode($org['db']));
		$record->save();
		return 'pk';

	}


		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Meeting::destroy($id);

		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('meeting.index');
	}


	public function save_db($record,$error_redirect,$success_msg){

		$fields=Meeting::getFillables();
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
		);

		$labels=Meeting::getLabels();
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

		$records=Meeting::getAllRecordsByIds($ids);
		if(count($records)<1){return;}


		$rows=array();
		$headings=array("District","Dates","Right Based Organizations","Political Personalities","Government Departments","District Bar");
		array_push($rows,$headings);
		foreach ($records as $record) {
			
			$a=json_decode($record['rightbased_org'],true);
			$b=json_decode($record['political_personalities'],true);
			$c=json_decode($record['goveronment_deps'],true);
			$d=json_decode($record['district_bar'],true);
			
			$max=max([count($a),count($b),count($c),count($d)]);
			
			for($i=0;$i<$max;$i++){
			
				if(!isset($a[$i])){$a[$i]["name"]="";$a[$i]["persons"]=[];}
				if(!isset($b[$i])){$b[$i]["name"]="";$b[$i]["persons"]=[];}
				if(!isset($c[$i])){$c[$i]["name"]="";$c[$i]["persons"]=[];}
				if(!isset($d[$i])){$d[$i]["name"]="";$d[$i]["persons"]=[];}
			}
			
			
			for($i=0;$i<$max;$i++){
				
				
				if($i==0){
					array_push($rows,[$record['district_id'],$record['date'],$a[$i]['name'],$b[$i]['name'],$c[$i]['name'],$d[$i]['name']]);
					array_push($rows,['','',implode("\n",$a[$i]['persons']),
					implode("\n",$b[$i]['persons']),implode("\n",$c[$i]['persons']),implode("\n",$d[$i]['persons'])]);
				}
				else{
					array_push($rows,['','',$a[$i]['name'],$b[$i]['name'],$c[$i]['name'],$d[$i]['name']]);
					array_push($rows,['','',implode("\n",$a[$i]['persons']),
					implode("\n",$b[$i]['persons']),implode("\n",$c[$i]['persons']),implode("\n",$d[$i]['persons'])]);
				}
			}

		}

		$file=createExcel2(array("name"=>$this->heading),$rows);
		
		return json_encode(array("path"=>$file));
	}

}
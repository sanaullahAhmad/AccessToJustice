<?php

class SycopCall extends Eloquent{
	
	/*
			name , date , call_type , gender , contact , address , priority_group_id , minority_group_id ,
			case_nature , action_taken , refer , call_taken_by , call_taken_by , center_id 
		*/
	protected $table='sycop_calls';
	
	protected $fillable = array(

		'name',
		'date',
		'first_follow',
		'gender',
		'contact_no',
		'caller_district',
		'priority_group',
		'callback',
		'refered_from',
		'refered_to',
		'refer',
		'staff_name',
		"center_id");


	public function center(){

		return $this->belongsTo('Center');
	}

	protected function getLabels(){

		$labels= array(
			"Caller",
			"Date",
			"First/Follow-up Call",
			"Gender (M, F or TG)",
			"Contact Number", 
			"Caller District",
			"Priority Group",
			"Callback",
			"Referred From",
			"Referred To (LAC Name)",
			"Refer",
			"Staff Name",
			'Center');



	return mapArrays($this->fillable,$labels);
	}

	protected function getFillables(){	return $this->fillable;	}


	protected function getStartDate(){
		return $this->where('date','>',0)->orderBy('date', 'asc')->first();
	}
	protected function getAllRecords(){

		$records=$this->all();

		if(Auth::check() && Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			$records=$this->where('center_id','=',$center['id'])->get();
		}

		$new_records=array();
		
		foreach ($records as $record) {
			
			$arr=array();
			$object=$record->original;
			foreach ($object as $key => $value) {
				  
				if(in_array($key, $this->fillable)|| $key=='id'){
					
					if(strpos($key, '_id')>0)
					{
						$func=str_replace("_id", "", $key);
						$tmp=$record->$func()->get()->toArray(); 
						$arr[$key]=count($tmp)>0?$tmp[0]['name']:'';	
					}else{
						$arr[$key]=$value;
					}
				}
			}

			
			array_push($new_records, $arr);
		}

		return $new_records;
	}
    protected function getLimitRecords($limit)
    {

        $records = $this->limit($limit)->get();
        $new_records=array();

        foreach ($records as $record) {

            $arr=array();
            $object=$record->original;
            foreach ($object as $key => $value) {

                if(in_array($key, $this->fillable)|| $key=='id'){

                    if(strpos($key, '_id')>0)
                    {
                        $func=str_replace("_id", "", $key);
                        $tmp=$record->$func()->get()->toArray();
                        $arr[$key]=count($tmp)>0?$tmp[0]['name']:'';
                    }else{
                        $arr[$key]=$value;
                    }
                }
            }


            array_push($new_records, $arr);
        }

        return $new_records;
    }
    protected function getCenterRecords($city)
    {

        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        $records = $this->where('center_id', '=', $center->id)->limit(60)->get();
        $new_records=array();

        foreach ($records as $record) {

            $arr=array();
            $object=$record->original;
            foreach ($object as $key => $value) {

                if(in_array($key, $this->fillable)|| $key=='id'){

                    if(strpos($key, '_id')>0)
                    {
                        $func=str_replace("_id", "", $key);
                        $tmp=$record->$func()->get()->toArray();
                        $arr[$key]=count($tmp)>0?$tmp[0]['name']:'';
                    }else{
                        $arr[$key]=$value;
                    }
                }
            }


            array_push($new_records, $arr);
        }

        return $new_records;
    }

	protected function getAllRecordsByIds($ids,$fields=[]){

		$records=$this->all();

		if(count($fields)>0){
			array_unshift($fields, 'id');
			$records=$this->all($fields);			
		}

		if(Auth::check() && Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();
			$records=$this->where('center_id','=',$center['id']);
			if(count($fields)>0){
				array_unshift($fields, 'id');			
				$records=$this->select($fields)->where('center_id','=',$center['id'])->get();
			}
		}
		
		$new_records=array();
		
		foreach ($records as $record) {
			
			$arr=array();
			$object=$record->original;
			if(in_array($object['id'], $ids)){

				foreach ($object as $key => $value) {
				  
					if(in_array($key, $this->fillable)|| $key=='id'){
						
						if(strpos($key, '_id')>0)
						{
							$func=str_replace("_id", "", $key);
							$tmp=$record->$func()->get()->toArray(); 
							$arr[$key]=count($tmp)>0?$tmp[0]['name']:'';	
						}else{
							$arr[$key]=$value;
						}
					}
				}
				
				array_push($new_records, $arr);
			}
		}

		return $new_records;
	}

	
}

?>
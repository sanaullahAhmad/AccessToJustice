<?php

class Partner extends Eloquent{
	
	protected $fillable = array('name','address','website','experience','experience-summary','focal-person',
		   'focal-person-designation','focal-person-phone','district_id');

	public function district(){

		return $this->belongsTo('District');
	}

	protected function getLabels(){

		$labels= array('Name','Address','Website','Experience','Experience Summary','Focal Person',
						'Focal Person Designation','Focal Person Phone','District');
		
		return mapArrays($this->fillable,$labels);

	}

	protected function getFillables(){	return $this->fillable;	}


	protected function getAllRecords(){

		$records=$this->all();
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
					}
					else{
						$arr[$key]=$value;
					}
				}
			}

			array_push($new_records, $arr);
		}

		return $new_records;
	}

	protected function getAllRecordsByIds($ids){

		$records=$this->all();
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
						}
						else{
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
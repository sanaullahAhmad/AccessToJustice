<?php

class ProblemNature extends Eloquent{
	protected $fillable = array('name','status','problemgroup');
	public function legal_assistances(){
		return $this->hasMany('LegalAssistance');
	}
	protected function getLabels(){
		$labels= array('Name','status','Problem Group');
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
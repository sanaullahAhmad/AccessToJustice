<?php

class Meeting extends Eloquent{
	
	protected $table='meetings';

	protected $fillable = array('rightbased_org','goveronment_deps','political_personalities','district_bar','district_id',"date","quater","social_activists");

	protected function getFillables(){	return $this->fillable;	}

	public function district(){

		return $this->belongsTo('District');
	} 

	protected function getAllRecords(){

		$records=$this->all();
		if(Entrust::hasRole('Center_User')){
			$district=Confide::user()->center()->first()->district()->first();
			$records=$this->where('district_id','=',$district['id'])->get();
			 
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
		if(Entrust::hasRole('Center_User')){
			$district=Confide::user()->center()->first()->district()->first();
			$records=$this->where('district_id','=',$district['id'])->get();
			 
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
<?php

class EventsCategories extends Eloquent{
	
	
	protected $fillable = array('name', 'color');

	
	public function incoming_calls(){

		return $this->hasMany('IncomingCall');
	}
    public function center(){
        return $this->belongsTo('Center');
    }

    protected function getLabels(){
		$labels= array('Name','Color');
		return mapArrays($this->fillable, $labels);
	}

	protected function getFillables(){	return $this->fillable;	}


	protected function getAllRecords(){
		$records=$this->all();
        //dd($records);

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
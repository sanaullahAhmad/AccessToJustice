<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface
{
	use HasRole;
 	use ConfideUser;

 	protected $fillable = array('username','email','blocked','password','updated_at','start_date','end_date');


 	public function center(){

 		return $this->belongsToMany('Center');
 	}

 	protected function getLabels(){

		$labels= array('Username','Email','Password','Last Login');
		return mapArrays($this->fillable,$labels);
	}

	protected function getFillables(){	return $this->fillable;	}


	protected function getAllCenterUsers(){
		$records=Role::find(2)->users()->get();
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

			$center=$record->center()->first();
			if($center){
				$arr['center_id']=$center->name;	
			}else $arr['center_id']='';	
			
			array_push($new_records, $arr);
		}
		
		return $new_records;
	}

	protected function getAllNormalUsers(){
		$records=Role::find(3)->users()->get();
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


 	protected function getAllRecords($role){

		$records=Role::find($role)->users()->get();
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
}
<?php

class Center extends Eloquent{
	

	/*
				name , address , timings , phone , mobile , 
				district_id , partner_id , coordinator , coordinator-number
			*/
	protected $fillable = array('name', 'address', 'timings', 'phone', 'mobile'
								, 'district_id', 'partner_id', 'coordinator','coordinator-number');

	public function district(){

		return $this->belongsTo('District');
	}
	
	public function partner(){

		return $this->belongsTo('Partner');
	}

	public function lawyer(){

		return $this->hasMany('Lawyer');
	}

	public function support_organization(){

		return $this->hasMany('SupportOrganization');
	}

	public function staff(){

		return $this->hasMany('CenterStaff');
	}

	public function users(){
		
		return $this->belongsToMany('User');
	}

	public function outgoing_calls(){

		return $this->hasMany('OutgoingCall');
	}

	public function incoming_calls(){

		return $this->hasMany('IncomingCall');
	}

	public function sycop_calls(){
		return $this->hasMany('SycopCall');	
	}

	public function walkins(){
		return $this->hasMany('Walkin');	
	}

	public function cases(){

		return $this->hasMany('Case');
	}

	public function legal_aids(){

		return $this->hasMany('LegalAid');
	}

	public function legal_assistances(){

		return $this->hasMany('LegalAssistance');
	}

	protected function getLabels(){

		$labels= array('Name','Address','Timings','Phone','Mobile','District','Partner','Co-Ordinator','Co-Ordinator Phone');
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
<?php

class LegalAssistance extends Eloquent{
	
	/*
			name , date , call_type , gender , contact , address , priority_group_id , minority_group_id ,
			case_nature , action_taken , refer , call_taken_by , call_taken_by , center_id 
		*/
			protected $table='legal_assistances';
			
			protected $fillable = array(
				'name',
				'contact',
				'gender',
				'age',
				'cnic',
				'occupation',
				'marital_status',
				'address',
				'tehsil',
				'guardian',
				'relation_with_guardian',
				'contact_guardian',
				'priority_group_id',
				'minority_group_id',
				'psychosocial_support',
				'problem_nature_id',
				'action_taken',
				'institution',
				'lawyer_name',
				'lawyer_cell_no',
				'date',
				'referred_from',
				'stage_proceeding',
				'decision',
				'decision_date',
'decision_result',
				'center_id');


			public function center(){

				return $this->belongsTo('Center');
			}
			
			public function minority_group(){

				return $this->belongsTo('MinorityGroup');
			}

			public function priority_group(){

				return $this->belongsTo('PriorityGroup');
			}

	protected function getStartDate(){
		return $this->where('date','>',0)->orderBy('date', 'asc')->first();
	}
			public function problem_nature(){

				return $this->belongsTo('ProblemNature');
			}

			protected function getLabels(){

				$labels= array(
					'Name Of Party',
					'Contact Number',
					'Gender (M, F or TG)',
					'Age',
					'CNIC #',
					'Occupation',
					'Marital Status',
					'Address',
					'Tehsil',
					'Name of Guardian',
					'Relation with Guardian',
					'Guardian Contact Number',
					'Priority Group (GBV, Minority and Disabled)',
					'if Minority name Group',
					'Psychosocial Support Provided (Yes/No)',
					'Nature Of Problem',
					'Action Taken ',
					'Name of Institution Handling Case',
					'Lawyer Name (if involved)',
					'Lawyer Cell No.',
					'Date of Assistance Provided',
					'Case Referred From',
					'Stage Proceeding (In progress or Completed)',
					'Decision (if case concluded)',
					"Case Concluding Month",
                    "Decision Result",
					'Center');




				return mapArrays($this->fillable,$labels);
			}

			protected function getFillables(){	return $this->fillable;	}


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
    protected function getLimitRecords($limit){
        $records=$this->limit($limit)->get();
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
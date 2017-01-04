<?php
ini_set('max_execution_time', 52860);
ini_set('memory_limit', '-1');

	 function getExcelAllRows($path,$numberOfColumns=0){

			$objPHPExcel = PHPExcel_IOFactory::load($path);
			$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
			$array_data = array();
			foreach ($rowIterator as $row) {

				$row_array=array();
				$cellIterator = $row->getCellIterator();
				
				$numberOfColumns=$numberOfColumns>0?$numberOfColumns:count($cellIterator);
				$tmp=0;
				foreach ($cellIterator as $cell) { 
					// echo $cell->getFormattedValue().",";
					$cellval= empty(trim($cell->getFormattedValue()))?'-':$cell->getFormattedValue();
					array_push($row_array, trim($cellval)."");	
					$tmp++;
					if($tmp==$numberOfColumns){break;}
				}
				
				for($i=0;$i<($numberOfColumns-$tmp);$i++){array_push($row_array,'');}
				
				
				if(!empty(str_replace("-","",implode("",$row_array )))){
					array_push($array_data,$row_array);	
				}
			}
			
			return $array_data;
	}

	function mapArrays($keys,$values){

		$arr=array();

		for($i=0;$i<count($keys);$i++)
		{
			$arr[$keys[$i]]=isset($values[$i])?$values[$i]:'';
		}

		return $arr;
	}

	function retrieveField($rows,$field){

		$arr=array();
		if(!isset($rows)){return $arr;}
		
		foreach($rows as $row) { 
			$arr[$row->id]=$row->$field;
		}

		return $arr;

	}


	function filterFields($model,$records,$fields){

		$filtered_records=array();

		foreach ($records as $record) {

			$filtered_record=[];
			
			foreach ($fields as $field) {
				
				if(strpos($field, '_id')>0 && is_numeric($record->$field))
				{
					// echo $field;
					$func=str_replace("_id", "", $field);
					
					$tmp=$model::find($record->id)->$func()->get()->toArray(); 
					
					
					$name=count($tmp)>0?$tmp[0]['name']:'';
					array_push($filtered_record,$name);
				}else{
					// echo $field;
					array_push($filtered_record,$record->$field);
				}

			}
			// var_dump($records);
			// var_dump($fields);var_dump($filtered_record);exit();
			// foreach($record as $key=>$value){
			// 	if(in_array($key, $fields)){
			// 		if(strpos($key, '_id')>0)
			// 		{
			// 			$func=str_replace("_id", "", $key);

			// 			$tmp=$model::find($record->id)->$func()->get()->toArray(); 
			// 			$name=count($tmp)>0?$tmp[0]['name']:'';
			// 			array_push($filtered_record,$name);
			// 		}
			// 		else{
			// 			array_push($filtered_record,$value);	
			// 		}
			// 	}
			// }

			array_push($filtered_records, $filtered_record);
		}


		return $filtered_records;
	}

	function getGenderOptions(){

		return array(
			""=>"-",
				'Male'=>'Male',
				'Female'=>'Female',
				'TransGender'=>'TransGender'
			);
	}

	function getMaritalStatusOptions(){

		return array(
			""=>"-",
				'Married'=>'Married',
				'Single'=>'Single',
                'Widow'=>'Widow',
				'Divorced'=>'Divorced'
			);
	}

	function getPyscoSupportOptions(){

		return array(
			""=>"-",
				'Yes'=>'Yes',
				'No'=>'No'
			);
	}

	function getCaseTypeOptions(){

		return array(
				""=>"-",
				'Family'=>'Family',
				'Civil'=>'Civil',
				'Revenue & Others'=>'Revenue & Others',
				'Criminal'=>'Criminal'
			);
	}

	function getStageProceedingOptions(){

		return array(
				""=>"-",
				'Completed'=>'Completed',
				'In Progress'=>'In Progress'
			);
	}

	function getVisistType(){

		return array(
			""=>"-",
			"Personal"=>"Personal",
			"Third Party"=>"Third Party",
			"Neutral Party"=>"Neutral Party",
		);
	}
/*function getVisistReason(){

    return array(
        ""=>"-",
        "Psychological support "    =>  "Psychological support ",
        "Awareness"                 =>  "Awareness",
        "Legal Advice"              =>  "Legal Advice",
        "Legal Assistance"          =>  "Legal Assistance",
    );
}*/

    function getVisistTime(){
        return array(
            ""=>"-",
            "First Time"=>"First Time",
            "Follow-up"=>"Follow-up"
        );
    }

    function getRateLegalAidService(){
        return array(
            ""=>"-",
            "Satisfied"=>"Satisfied",
            "Just Satisfied"=>"Just Satisfied",
            "Completely Satisfied"=>"Completely Satisfied",
        );
    }
	
	function getVisistReason(){

		return array( 

			""=>"-",
			"Psychosocial Support"=>"Psychosocial Support",
			"Legal Advice"=>"Legal Advice",
			"Awareness"=>"Awareness",
			"Legal Assistance"=>"Legal Assistance",
		);
	}

	function createExcel($fileInfo,$rows,$dateIndex=-1){

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);
		$coulmnNames=explode(",",'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,AA,AB,AC,AD,AE,AF,AG,AH,AI,AJ,AK,AL,AM');
		$rowsCounter=1;

		foreach ($rows as $row) {
			
			$labelCounter=0;
		 	
			foreach ($row as $key => $value) {
				
				if($key=='date' && $rowsCounter>1){
					 
					$value=date('m/d/Y', intval($row['date']));
					 
				}

				$objPHPExcel->getActiveSheet()->SetCellValue($coulmnNames[$labelCounter].$rowsCounter,$value);	
				$labelCounter++;
			}

			$rowsCounter++;
		}
		// exit;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$fileInfo['name'].'.xls"');

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$filename="tmp/".generateRandomString().'.xlsx';
		$objWriter->save($filename);
		
		return $filename;
	}
	
	function createExcel2($fileInfo,$rows,$dateIndex=-1){

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);
		$coulmnNames=explode(",",'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,AA,AB,AC,AD,AE,AF,AG,AH,AI,AJ,AK,AL,AM');
		$rowsCounter=1;

		foreach ($rows as $row) {
			
			$labelCounter=0;
		 	
			foreach ($row as $key => $value) {


				$objPHPExcel->getActiveSheet()->SetCellValue($coulmnNames[$labelCounter].$rowsCounter,$value);	
				$labelCounter++;
			}

			$rowsCounter++;
		}
		// exit;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$fileInfo['name'].'.xls"');

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$filename="tmp/".generateRandomString().'.xlsx';
		$objWriter->save($filename);
		
		return $filename;
	}
	
	function downloadfile($file){
		
		if (file_exists(public_path().'/'.$file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}else{return "no";}
	}
	
	function generateRandomString($length = 10) {
	    
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	    
	}

	function create_pdf($html,$title='Reports',$landscape=false){

		
		$pdf = App::make('dompdf');
		$pdf->loadHTML($html);
		if($landscape) $pdf->setOrientation('landscape');
		$filename="tmp/".generateRandomString().'.pdf';
		
 		$pdf->save($filename);
    		 
		return $filename;
	}

	function getValues($fields,$labels){

		$tmp=array();

		foreach ($fields as $field) {
			array_push($tmp, $labels[$field]);
		}

		return $tmp;
	}

	function transform_date($date){

		$date=trim($date);
		$default='2015-01-01';
		$parts=explode("-", $date);
		$valid=is_array($parts) && count($parts)==3;

		$date=$valid?$date:$default;

		return strtotime($date);
	}

	function getRecordsByDate($table,$date,$center=-1){
		// var_dump($date);
		$center_query=intval($center)==-1?'':' and center_id='.$center;
		$results=DB::select(DB::raw("SELECT * FROM $table WHERE `date`>=:rfrom and `date`<=:rto".$center_query),array(
				'rfrom'=>strtotime(date_pad($date[0])),
				'rto'=>strtotime(date_pad($date[1]))
			));
		//var_dump(DB::getQueryLog());
		return $results;
	}

    function getRecordsByDateAndGender($table,$date,$center=-1, $fields=array()){
        // var_dump($date);
        $center_query=intval($center)==-1?'':' and center_id='.$center;
        if($fields)
        {
            foreach ($fields as $field_key=> $field_value)
            {
                    $center_query.=" AND ( $field_key = '$field_value')";
            }
        }

        $results=DB::select(DB::raw("SELECT * FROM $table WHERE `date`>=:rfrom and `date`<=:rto".$center_query),array(
            'rfrom'=>strtotime(date_pad($date[0])),
            'rto'=>strtotime(date_pad($date[1]))
        ));

        //var_dump(DB::getQueryLog());
        return $results;

    }

	function date_pad($date){
		$date=explode("-", $date);
		$date[0]=str_pad($date[0], 2, "0", STR_PAD_LEFT);
		$date[1]=str_pad($date[1], 2, "0", STR_PAD_LEFT);
		return implode("/", $date);
	}

	function getMonthLabel($i){

		$months=[
					"Jan","Feb","Mar",
					"Apr","May","Jun",
					"Jul","Aug","Sep",
					"Oct","Nov","Dec"
		];
		return $months[$i-1];
	}

	function getWeeksDateRange($m,$y){

		// dd([$m,$y]);
		$days=days_in_month(intval($m),intval($y));
		return [
					[$m.'-'.'01'.'-'.$y,$m.'-'.'07'.'-'.$y],
					[$m.'-'.'08'.'-'.$y,$m.'-'.'14'.'-'.$y],
					[$m.'-'.'15'.'-'.$y,$m.'-'.'21'.'-'.$y],
					[$m.'-'.'22'.'-'.$y,$m.'-'.$days.'-'.$y]
				];

	}


	 function days_in_month($month, $year) 
	{ 
	// calculate number of days in a month 
	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	} 

	function getMonthsDateRange($y){

		$months=[];
		for ($i=1; $i <= 12; $i++) { 
			
			
			$days=cal_days_in_month(CAL_GREGORIAN,$i,$y);

			array_push($months, [$i.'-01-'.$y,$i.'-'.$days.'-'.$y]);
		}
		
		return $months;
	}


	function getQuatersDateRange($y){

		return [
					['01'.'-'.'01'.'-'.$y,'03'.'-'.'31'.'-'.$y],
					['04'.'-'.'01'.'-'.$y,'06'.'-'.'30'.'-'.$y],
					['07'.'-'.'01'.'-'.$y,'09'.'-'.'30'.'-'.$y],
					['10'.'-'.'01'.'-'.$y,'12'.'-'.'31'.'-'.$y]
				];
	}



?>
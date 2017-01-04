<?php

class LegalAidsController extends \BaseController {

    private $heading="Legal Advice and Counselling";

    public function pre_index(){


        /*$records=LegalAid::getAllRecords();
        $centers=retrieveField(Center::all(),'name');
        $decentrailzed_records=[];

        foreach ($centers as $key => $value) {
            $decentrailzed_records[$value]=0;
        }

        foreach ($records as $record) {

            if(trim($record['center_id'])!=''){
                $decentrailzed_records[$record['center_id']]+=1;
            }

        }*/
        $centers=retrieveField(Center::all(),'name');//old
        $decentrailzed_records=[];
        $total_count=0;
        foreach ($centers as $key => $value) {
            $center_count = \DB::table('legalaids')
                ->where('center_id', '=', $key)
                ->count();

            $decentrailzed_records[$value]=$center_count;
            $total_count+=$center_count;
        }

        $charts_data=[];

        foreach ($decentrailzed_records as $key => $value) {

            array_push($charts_data, [$key,$value]);
        }


        $data=[
            "heading"=>$this->heading,
            "records"=>$decentrailzed_records,
            "total"=>$total_count,
            "index_route"=>"legalaid",
            "charts_data"=>json_encode($charts_data)
        ];


        return View::make('layouts.records.pre_index')->with('data', $data);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $heading=$this->heading;
        $records=LegalAid::getLimitRecords(60);
        array_splice($records, 60);
        $display_fields=array('name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');

        $labels=LegalAid::getLabels();
        $current_route_base='legalaid';
        $table='legalaids';
        $ajaxi_used='ajaxi';
        $create_link='legalaid.create';
        $iec_link='iec.index';
        $delete_link='legalaid.delete';
        $excel_download_link='legalaid.download_excel';
        $pdf_download_link='legalaid.download_pdf';
        $report_download_link='legalaid.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),$labels),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>$centers);
        $has_reports=true;
        $small_form=false;
        $start_date=LegalAid::getStartDate();

        $data=array(

            'heading'=>$heading,
            'fields'=>$display_fields,
            'labels'=>$labels,
            'records'=>$records,
            'records_count'=>count($records),
            'current_route_base'=>$current_route_base,
            'table'=>$table,
            'ajaxi_used'=>$ajaxi_used,
            'create_link'=>$create_link,
            'iec_link'=>$iec_link,
            'delete_link'=>$delete_link,
            'excel_download_link'=>$excel_download_link,
            'pdf_download_link'=>$pdf_download_link,
            'report_download_link'=>$report_download_link,
            'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
            'has_reports'=>$has_reports,
            'small_form'=>$small_form,
            'start_date'=>$start_date
        );
        return View::make('layouts.records.index')->with('data', $data);
    }

    public function center($city)
    {
        //dd($city);
        $heading=$this->heading;
        $records=LegalAid::getCenterRecords($city);
        //array_splice($records, 20);
        $display_fields=array('name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');

        $labels=LegalAid::getLabels();
        $current_route_base='legalaid';
        $table='legalaids';
        $ajaxi_used='center_ajaxi/'.$city;
        $create_link='legalaid.create';
        $iec_link='iec.index';
        $delete_link='legalaid.delete';
        $excel_download_link='legalaid.download_excel';
        $pdf_download_link='legalaid.download_pdf';
        $report_download_link='legalaid.download_report_pdf';
        $centers=array_values(retrieveField(Center::all(),'name'));
        sort( $centers );
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),$labels),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>$centers);
        $has_reports=true;
        $small_form=false;
        $start_date=LegalAid::getStartDate();

        $data=array(

            'heading'=>$heading,
            'fields'=>$display_fields,
            'labels'=>$labels,
            'records'=>$records,
            'records_count'=>count($records),
            'current_route_base'=>$current_route_base,
            'table'=>$table,
            'ajaxi_used'=>$ajaxi_used,
            'create_link'=>$create_link,
            'iec_link'=>$iec_link,
            'delete_link'=>$delete_link,
            'excel_download_link'=>$excel_download_link,
            'pdf_download_link'=>$pdf_download_link,
            'report_download_link'=>$report_download_link,
            'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
            'has_reports'=>$has_reports,
            'small_form'=>$small_form,
            'start_date'=>$start_date
        );

        //echo "<pre>";dd($data);exit;
        return View::make('layouts.records.index')->with('data', $data);
    }

    public function center_ajaxi($city)
    {
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        $records= \DB::table('legalaids')->where('center_id','=',$center->id)->get();
        $display_fields=array('id','name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAid::getLabels()),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>array_values(retrieveField(Center::all(),'name')));

        $records=filterFields('LegalAid',$records,$display_fields);
        $records=array_slice($records,60);

        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $elements_data=$this->generate_form();
        $data['elements_data']=$elements_data;
        $data['can_import']=true;
        $data['centers']=retrieveField(Center::all(),'name');
        $data['submit_url']='legalaid.store';
        $data['upload_submit_url']='legalaid.excel';
        $data['heading']='Legal Aid and Advice';
        $data['go_back']='legalaid.index';

        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $data['centers']=[$center['id']=>$center['name']];
        }

        return View::make('layouts.records.add')->with('data',$data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        $record=new LegalAid;
        $this->save_db($record,'legalaid.create','Successfully created the record!');
        return Redirect::route('legalaid.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $record=LegalAid::find($id);
        if(!$record){return;}

        $data['go_back']='legalaid.index';
        $data['heading']='Legal Aid and Advice';

        $labels=LegalAid::getLabels();
        foreach ($labels as $key => $value) {

            if(strpos($key, '_id')>0)
            {
                $func=str_replace("_id", "", $key);
                $tmp=$record->$func()->get()->toArray();
                $data['rows'][$value]=$tmp[0]['name'];
            }
            else{
                $data['rows'][$value]=$record->$key;
            }
        }

        return View::make('layouts.records.detail')->with('data', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $record=LegalAid::find($id);
        $elements_data=$this->generate_form($record->toArray());
        $data['elements_data']=$elements_data;
        $data['can_import']=true;
        $data['centers']=retrieveField(Center::all(),'name');
        $data['submit_url']='legalaid.update';
        $data['heading']='Legal Aid and Advice';
        $data['go_back']='legalaid.index';
        $data['record_id']=$record['id'];

        return View::make('layouts.records.edit')->with('data', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

        $record=LegalAid::find($id);
        $this->save_db($record,'legalaid.edit','Successfully updated the record!');
        return Redirect::route('legalaid.index');

    }

    public function excel(){

        $centers=retrieveField(Center::all(),'name');//old
        $center_id=Input::get('center_id');

        $extension = Input::file('file')->getClientOriginalExtension();
        $fileName=microtime().'.'.$extension;
        Input::file('file')->move(__DIR__.'/storage/dump/',$fileName);
        if($center_id=='')
        {
            $field_count= 23;
        }
        else{
            $field_count=22;
        }
        $rows=getExcelAllRows(__DIR__.'/storage/dump/'.$fileName,$field_count);
        $rows=array_slice($rows, 4);

        foreach ($rows as $row) {

            $is_empty=trim(implode("",$row));


            if($is_empty!=""){

                array_shift($row);
                $t1=(PriorityGroup::firstOrCreate(array('name'=>$row[12])));
                $t2=(MinorityGroup::firstOrCreate(array('name'=>$row[13])));
                $t3=(CaseNature::firstOrCreate(array('name'=>$row[15])));

                $row[12]=$t1->id;
                $row[13]=$t2->id;
                $row[15]=$t3->id;

                $row[1]=transform_date($row[1]);
                if($center_id=='')
                {
                    foreach ($centers as $cen_key=>$cen_val)
                    {
                        if($cen_val==$row[21])
                        {
                            $row[21] = $cen_key;
                        }
                    }
                }
                else{
                    array_push($row, $center_id);
                }


                $row=mapArrays(LegalAid::getFillables(),$row);
                str_replace(",", "%2C", $row);
                LegalAid::create($row);
            }
        }

        Session::flash('message', 'All records has been imported');
        Session::flash('alert-class', 'alert-success');
        return Redirect::route('legalaid.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        LegalAid::destroy($id);

        Session::flash('message', 'Successfully deleted  the record');
        Session::flash('alert-class', 'alert-success');
        return Redirect::route('legalaid.index');
    }


    public function save_db($record,$error_redirect,$success_msg){

        $fields=LegalAid::getFillables();
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

            $inputs=Input::all();
            $inputs['date']=transform_date(Input::get('date'));
            foreach ($fields as $field) {
                $record->$field=$inputs[$field];
            }
            $record->save();

            Session::flash('message', $success_msg);
            Session::flash('alert-class', 'alert-success');

        }
    }

    public function generate_form($values=array()){


        //$a=retrieveField(PriorityGroup::all(),'name');//'GBV','Person With Disabillity','Minority','Other'
        /*$a = array();
        $a[2] = "GBV";
        $a[3] = "Persons With Disabillities";
        $a[6] = "Minorities";
        $a[1] = "Others";*/
        $Priority_array= array();
        $records= \DB::table('priority_groups')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $Priority_array[$record->id] = $record->name;
        }
        $a= $Priority_array;


        //$b=retrieveField(MinorityGroup::all(),'name');//'Christian', 'Hindo', 'Sikh', 'Hazara', 'Ahmadi'/*$b[14] = "Muslim";*/
        /*$b=array();
        $b[24] = "N.A";
        $b[2] = "Christian";
        $b[17] = "Hindu";
        $b[51] = "Sikh";
        $b[15] = "Hazara";
        $b[37] = "Ahmadi";*/
        $MinorityGroup_array= array();
        $records= \DB::table('minority_groups')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $MinorityGroup_array[$record->id] = $record->name;
        }
        $b= $MinorityGroup_array;


        //$c=retrieveField(CaseNature::all(),'name');
        //        //$records= \DB::table('case_natures')->whereIn('id',[473, 23, 472, 269, 13, 451, 271, 151, 9, 135, 264, 161, 23, 448, 127, 175, 403, 181, 135, 387, 472, 175, 312, 470, 457, 183, 9, 501, 462, 446, 502, 474])->get();
        /*$case_natures_array= array();
        $records= \DB::table('case_natures')->where('status','=','show')->get();
        foreach ($records as $record)
        {
            $case_natures_array[$record->id] = $record->name;
        }
        $c= $case_natures_array;*/

        $d=retrieveField(Center::all(),'name');

        $heard_abouts_array= array();
        $records= \DB::table('heard_abouts')->get();
        foreach ($records as $record)
        {
            $heard_abouts_array[$record->name] = $record->name;
        }
        $g= $heard_abouts_array;

        $options=array(
            'gender'=>getGenderOptions(),
            'marital_status'=>getMaritalStatusOptions(),
            'psychosocial_support'=>getPyscoSupportOptions(),
            'case_type'=>getCaseTypeOptions(),
            'stage_proceeding'=>getStageProceedingOptions(),
            'visit_type'=>getVisistType(),
            'visit_reason'=>getVisistReason(),
            'first_follow_visit'=>getVisistTime(),
            'priority_group_id'=>$a,
            'minority_group_id'=>$b,
            'ratings'=>getRateLegalAidService(),
            /*'case_nature_id'=>$c,*/
            'heard_from'=> $g,
            'center_id'=>$d
        );

        if(Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $options['center_id']=[$center['id']=>$center['name']];
        }

        $labels=LegalAid::getLabels();
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
        $case_natures_array= array();
        $case_natures_groups = DB::table('case_natures')->where( 'status', '=', 'show')->groupBy('casegroup')->get();
        foreach ($case_natures_groups as $group)
        {
            if($group->casegroup !='') {
                $groups_records = \DB::table('case_natures')->select('id', 'name')->where('casegroup', '=', $group->casegroup)->orderBy('name', 'asc')->get();
                $myarray = array();
                foreach ($groups_records as $record) {
                    $myarray[$record->id] = $record->name;
                }
                $case_natures_array[$group->casegroup] = $myarray;
            }
        }
        /*$elements_data['Nature of Advice']=array(
            "tag"=>"select_options","name"=>'case_nature_id',
            "value"=>"","options"=>$case_natures_array);*/
        
        /* $elements_data['Nature of Case']=array(
             "tag"=>"select_options","name"=>'case_nature_id',
             "value"=>"","options"=>array('Gender Based Violence (GBV)'=>array(
                 473=>'Mental Torture (Psychological Abuse)',
                 23=>'Physical Abuse',
                 472=>'Physical Abuse including leading to death',
                 269=>'Acid Crime',
                 13=>'Honour killing',
                 127=>'Sexual Abuse',
                 271=>'Rape / Gang Rape',
                 151=>'Burning',
                 9=>'Forced Marriage',
                 135=>'Inheritance/property rights',
                 264=>'Parental child kidnapping',
                 387=>'Discrimination or non-cooperation by law enforcement agencies'
             ),
                 'Children'=>array(
                     451=>'Mental torture, physical abuse, sexual abuse, child custody)',
                     428=>'Psychological abuse',
                     127=>'Sexual Abuse'
                 ),

                 'Persons with Disabilities'=>array(
                     175=>'Discrimination at workplace',
                     473=>'Mental Torture (Psychological Abuse)',
                     403=>'Harassment at workplace ',
                     181=>'Physical Abuse',
                     135=>'Inheritance/property rights',
                     161=>'Discrimination or non-cooperation by law enforcement agencies',
                     472=>'Physical Abuse including leading to death'
                 ),

                 'Minorities (Ethnic and Religious)'=>array(
                     175=>'Discrimination at workplace',
                     412=>'Freedom to practice religion',
                     470=>'Freedom to manage religious institutions',
                     457=>'Freedom of expression, assembly, association and thought',
                     183=>'Forced conversion',
                     9=>'Forced marriage ',
                     475=>'Forced participation in political activities',
                     387=>'Discrimination or non-cooperation by law enforcement agencies',
                     135=>'Inheritance/property rights',
                     270=>'Physical Violence',
                     474=>'Harasment'
                 ),
             )
         );*/

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
        $records=LegalAid::getAllRecordsByIds($ids);
        if(count($records)<1){return;}

        $rows=array();
        $headings=array();
        foreach ($records[0] as $key => $value) {
            array_push($headings,$key);
        }

        array_push($rows,$headings);
        $rows=array_merge($rows,$records);

        $file=createExcel(array("name"=>$this->heading),$rows,2);
        return json_encode(array("path"=>$file));
    }

    public function download_pdf(){

        $ids=explode(",",Input::get('ids'));
        $records=LegalAid::getAllRecordsByIds($ids,array('name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id'));
        if(count($records)<1){return;}
        $rows=array();
        $headings=array();
        foreach ($records[0] as $key => $value) {
            array_push($headings,$key);
        }
        $data=array("heading"=>"Legal Aid and Advice","headings"=>$headings,"records"=>$records);
        $html=View::make('layouts.pdf.record',array('data'=>$data));
        $file=create_pdf($html,'Legal Aid and Advice',true);
        return json_encode(array("path"=>$file));
    }

    public function download_report_pdf()
    {
        $data=json_decode(Input::get('json'),true);
        foreach ($data as $key => $value) {
            $value['html']=html_entity_decode($value['html'],ENT_COMPAT, 'UTF-8');
        }
        $html=View::make('layouts.pdf.report',array('data'=>$data));
        return create_pdf($html,'Legal Aid and Advice');
    }

    public function ajax(){
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));
        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];
        //$records=getRecordsByDate('legalaids',[$start,$end]);
        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $records=getRecordsByDate('legalaids',[$start,$end],$center->id);
        }else{
            $records=getRecordsByDate('legalaids',[$start,$end]);
        }
        // var_dump($records);exit;
        $display_fields=array('id','name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAid::getLabels()),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('LegalAid',$records,$display_fields);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }

    public function center_ajax($city){
        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();
        //01/27/2015
        $start=explode('/',Input::get('from'));
        $end=explode('/',Input::get('to'));
        $start=$start[2].'-'.$start[0].'-'.$start[1];
        $end=$end[2].'-'.$end[0].'-'.$end[1];
        $records=getRecordsByDate('legalaids',[$start,$end], $center->id);
        // var_dump($records);exit;
        $display_fields=array('id','name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAid::getLabels()),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('LegalAid',$records,$display_fields);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }

    public function ajaxi(){
        $records=[];
        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();

            $records=LegalAid::where('center_id','=',$center->id)->get();
        }else{
            $records=LegalAid::get();
        }
        // var_dump($records);exit;
        $display_fields=array('id','name','date','gender','visit_type','first_follow_visit','priority_group_id','minority_group_id',
            'psychosocial_support','case_nature_id','referred_to','center_id');
        $report_data=array("center_column"=>10,"reports_exception"=>getValues(array("name","contact","center_id"),LegalAid::getLabels()),"fof"=>4,"fofs"=>[2,7,1,6],
            "centers"=>array_values(retrieveField(Center::all(),'name')));
        $records=filterFields('LegalAid',$records,$display_fields);
        $records=array_slice($records,60);
        return json_encode(['records'=>$records,'report_data'=>$report_data]);
    }
}
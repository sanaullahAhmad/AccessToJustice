<?php

class OutgoingCallsController extends \BaseController

{

    private $heading = "Outgoing Calls";

    public function pre_index()

    {

        //$records=OutgoingCall::getAllRecords(); //old

        //$total_count = \DB::table('outgoing_calls')->count(); //new

        $centers = retrieveField(Center::all(), 'name');//old

        $decentrailzed_records = [];

        //$total_count = 0;

        foreach ($centers as $key => $value) {

            $center_count = \DB::table('outgoing_calls')

                ->where('center_id', '=', $key)

                ->count();

            $decentrailzed_records[$value] = $center_count;

            //$total_count += $center_count;

        }

        $total_count = \DB::table('outgoing_calls')->count();

        /*foreach ($records as $record) {

            if(trim($record['center_id'])!=''){

                $decentrailzed_records[$record['center_id']]+=1;

            }

        }*/

        $charts_data = [];

        foreach ($decentrailzed_records as $key => $value) {

            array_push($charts_data, [$key, $value]);

        }

//dd($decentrailzed_records);

        $data = [

            "heading" => $this->heading,

            "records" => $decentrailzed_records,

            "total" => $total_count,

            "index_route" => "outgoing",

            "charts_data" => json_encode($charts_data)

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

        $heading = $this->heading;

        $records = OutgoingCall::getLimitRecords(60);

        array_splice($records, 60);

        $display_fields = array('name', 'date','call_type', 'gender', 'contact', 'priority_group_id', 'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $labels = OutgoingCall::getLabels();

        $current_route_base = 'outgoing';

        $table = 'outgoing_calls';

        $ajaxi_used = 'ajaxi';

        $create_link = 'outgoing.create';

        $iec_link = 'iec.index';

        $delete_link = 'outgoing.delete';

        $excel_download_link = 'outgoing.download_excel';

        $pdf_download_link = 'outgoing.download_pdf';

        $report_download_link = 'outgoing.download_report_pdf';

        $centers = array_values(retrieveField(Center::all(), 'name'));

        sort($centers);

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"), $labels),

            "centers" => $centers);

        $has_reports = true;

        $small_form = false;

        $start_date = OutgoingCall::getStartDate();

        $data = array(

            'heading' => $heading,

            'fields' => $display_fields,

            'labels' => $labels,

            'records' => $records,

            'records_count' => count($records),

            'current_route_base' => $current_route_base,

            'table' => $table,

            'ajaxi_used' => $ajaxi_used,

            'create_link' => $create_link,

            'iec_link' => $iec_link,

            'delete_link' => $delete_link,

            'excel_download_link' => $excel_download_link,

            'pdf_download_link' => $pdf_download_link,

            'report_download_link' => $report_download_link,

            'report_data' => json_encode(array('data' => $report_data, 'has_reports' => $has_reports)),

            'has_reports' => $has_reports,

            'small_form' => $small_form,

            'start_date' => $start_date,

            'class' => 'outgoing'

        );

        return View::make('layouts.records.index')->with('data', $data);

    }

    public function center($city)

    {

        //dd($city);

        $heading = $this->heading;

        $records = OutgoingCall::getCenterRecords($city);

        //array_splice($records, 20);

        $display_fields = array('name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id', 'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $labels = OutgoingCall::getLabels();

        $current_route_base = 'outgoing';

        $table = 'outgoing_calls';

        $ajaxi_used = 'center_ajaxi/' . $city;

        $create_link = 'outgoing.create';

        $iec_link = 'iec.index';

        $delete_link = 'outgoing.delete';

        $excel_download_link = 'outgoing.download_excel';

        $pdf_download_link = 'outgoing.download_pdf';

        $report_download_link = 'outgoing.download_report_pdf';

        $centers = array_values(retrieveField(Center::all(), 'name'));

        sort($centers);

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"), $labels),

            "centers" => $centers);

        $has_reports = true;

        $small_form = false;

        $start_date = OutgoingCall::getStartDate();

        $data = array(

            'heading' => $heading,

            'fields' => $display_fields,

            'labels' => $labels,

            'records' => $records,

            'records_count' => count($records),

            'current_route_base' => $current_route_base,

            'table' => $table,

            'ajaxi_used' => $ajaxi_used,

            'create_link' => $create_link,

            'iec_link' => $iec_link,

            'delete_link' => $delete_link,

            'excel_download_link' => $excel_download_link,

            'pdf_download_link' => $pdf_download_link,

            'report_download_link' => $report_download_link,

            'report_data' => json_encode(array('data' => $report_data, 'has_reports' => $has_reports)),

            'has_reports' => $has_reports,

            'small_form' => $small_form,

            'start_date' => $start_date,

            'class' => 'outgoing'

        );

        return View::make('layouts.records.index')->with('data', $data);

    }

    public function center_ajaxi($city)

    {

        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();

        $records = \DB::table('outgoing_calls')->where('center_id', '=', $center->id)->get();

        $display_fields = array('id', 'name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id',

            'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"),

            OutgoingCall::getLabels()), "centers" => array_values(retrieveField(Center::all(), 'name')));

        $records = filterFields('OutgoingCall', $records, $display_fields);

        $records = array_slice($records, 60);

        return json_encode(['records' => $records, 'report_data' => $report_data]);

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return Response

     */

    public function create()

    {

        $elements_data = $this->generate_form();

        $data['elements_data'] = $elements_data;

        $data['can_import'] = true;

        $data['centers'] = retrieveField(Center::all(), 'name');

        $data['submit_url'] = 'outgoing.store';

        $data['upload_submit_url'] = 'outgoing.excel';

        $data['heading'] = 'Outgoing Calls';

        $data['go_back'] = 'outgoing.index';

        if (Auth::check() && Entrust::hasRole('Center_User')) {

            $center = Confide::user()->center()->first();

            $data['centers'] = [$center['id'] => $center['name']];

        }

        return View::make('layouts.records.add')->with('data', $data);

    }

    /**

     * Store a newly created resource in storage.

     *

     * @return Response

     */

    public function store()

    {

        $record = new OutgoingCall;

        $this->save_db($record, 'OutgoingCalls/create', 'Successfully created the record!');

        return Redirect::route('outgoing.index');

    }

    /**

     * Display the specified resource.

     *

     * @param  int $id

     * @return Response

     */

    public function show($id)

    {

        $record = OutgoingCall::find($id);

        if (!$record) {

            return;

        }

        $data['go_back'] = 'outgoing.index';

        $data['heading'] = 'Outgoing Calls';

        $labels = OutgoingCall::getLabels();

        foreach ($labels as $key => $value) {

            if (strpos($key, '_id') > 0) {

                $func = str_replace("_id", "", $key);

                $tmp = $record->$func()->get()->toArray();

                $data['rows'][$value] = $tmp[0]['name'];

            } else {

                $data['rows'][$value] = $record->$key;

            }

        }

        return View::make('layouts.records.detail')->with('data', $data);

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int $id

     * @return Response

     */

    public function edit($id)

    {

        $record = OutgoingCall::find($id);

        $elements_data = $this->generate_form($record->toArray());

        $data['elements_data'] = $elements_data;

        $data['can_import'] = true;

        $data['centers'] = retrieveField(Center::all(), 'name');

        $data['submit_url'] = 'outgoing.update';

        $data['heading'] = 'Outgoing Calls';

        $data['go_back'] = 'outgoing.index';

        $data['record_id'] = $record['id'];

        return View::make('layouts.records.edit')->with('data', $data);

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  int $id

     * @return Response

     */

    public function update($id)

    {

        $record = OutgoingCall::find($id);

        $this->save_db($record, 'outgoing.edit', 'Successfully updated the record!');

        return Redirect::route('outgoing.index');

    }

    public function excel()

    {

        $centers = retrieveField(Center::all(), 'name');

        $center_id = Input::get('center_id');

        $extension = Input::file('file')->getClientOriginalExtension();

        $fileName = microtime() . '.' . $extension;

        Input::file('file')->move(__DIR__ . '/storage/dump/', $fileName);

        if ($center_id == '') {

            $field_count = 16;

        } else {

            $field_count = 15;

        }

        $rows = getExcelAllRows(__DIR__ . '/storage/dump/' . $fileName, $field_count);

        $rows = array_slice($rows, 4);

        foreach ($rows as $row) {

            array_shift($row);

            $t1 = (PriorityGroup::firstOrCreate(array('name' => $row[8])));

            $t2 = (MinorityGroup::firstOrCreate(array('name' => $row[9])));

            $t3 = (CaseNature::firstOrCreate(array('name' => $row[10])));

            $row[8] = $t1->id;

            $row[9] = $t2->id;

            $row[10] = $t3->id;

            $row[1] = $row[1];

            //array_push($row, $center_id);

            //array_splice($row, 8, 1);

            if ($center_id == '') {
                //echo "if";

                foreach ($centers as $cen_key => $cen_val) {

                    if ($cen_val == $row[14]) {

                        $row[14] = $cen_key;

                    }

                }

            } else {
                //echo "else";

                array_push($row, $center_id);

            }

            $row[1] = transform_date($row[1]);
            //echo "<pre>";print_r($row);

            str_replace(",", "%2C", $row);

            $row = mapArrays(OutgoingCall::getFillables(), $row);
            //echo "<pre>";print_r($row);exit;

            OutgoingCall::create($row);

        }

        Session::flash('message', 'All records has been imported');

        Session::flash('alert-class', 'alert-success');

        return Redirect::route('outgoing.index');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int $id

     * @return Response

     */

    public function destroy($id)

    {

        OutgoingCall::destroy($id);

        Session::flash('message', 'Successfully deleted  the record');

        Session::flash('alert-class', 'alert-success');

        return Redirect::route('outgoing.index');

    }

    public function save_db($record, $error_redirect, $success_msg)

    {

        $fields = OutgoingCall::getFillables();

        $rules = array();

        foreach ($fields as $field) {

            $rules[$field] = 'required';

        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            // get the error messages from the validator

            $messages = $validator->messages();

            Session::flash('message', $messages->all());

            Session::flash('alert-class', 'alert-danger');

            return Redirect::route($error_redirect);

        } else {

            $inputs = Input::all();

            $inputs['date'] = transform_date(Input::get('date'));

            foreach ($fields as $field) {

                $record->$field = $inputs[$field];

            }

            $record->save();

            Session::flash('message', $success_msg);

            Session::flash('alert-class', 'alert-success');

        }

    }

    public function generate_form($values = array())

    {

        //$a=retrieveField(PriorityGroup::all(),'name');

        ////'GBV','Person With Disabillity','Minority','Other'

        /*$a = array();

        $a[2] = "GBV";

        $a[3] = "Persons With disabilities";

        $a[6] = "Minorities";

        $a[1] = "Others";*/

        $Priority_array= array();

        $records= \DB::table('priority_groups')->where('status','=','show')->get();

        foreach ($records as $record)

        {

            $Priority_array[$record->id] = $record->name;

        }

        $a= $Priority_array;



        //$b=retrieveField(MinorityGroup::all(),'name');//'Christian', 'Hindo', 'Sikh', 'Hazara', 'Ahmadi'

        ///*$b[14] = "Muslim";*/

        /*$b = array();

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







        //$c = retrieveField(CaseNature::all(), 'name');

        $case_natures_array= array();

        $records= \DB::table('case_natures')->where('status','=','show')->get();

        foreach ($records as $record)

        {

            $case_natures_array[$record->id] = $record->name;

        }

        $c= $case_natures_array;





        $d = retrieveField(Center::all(), 'name');



        $options = array(

            'gender' => getGenderOptions(),

            'priority_group_id' => $a,

            'minority_group_id' => $b,

            'call_type' => array('' => '-', 'First Time' => 'First Time', 'Follow-up' => 'Follow-up'),

            //'case_nature' => $c,

            'center_id' => $d

        );

        if (Entrust::hasRole('Center_User')) {

            $center = Confide::user()->center()->first();

            $options['center_id'] = [$center['id'] => $center['name']];

        }

        $labels = OutgoingCall::getLabels();

        $elements_data = array();

        foreach ($labels as $key => $value) {

            if (isset($options[$key])) {

                $arr = array(

                    "tag" => "select", "name" => $key,

                    "value" => "", "options" => $options[$key]

                );

            } else {

                $arr = array(

                    "tag" => "input", "name" => $key,

                    "value" => "", "type" => "text"

                );

            }

            $elements_data[$value] = $arr;

        }

        if (count($values) == 0) return $elements_data;

        $new_elements_data = array();

        foreach ($elements_data as $key => $array) {

            $k = $array['name'];

            if (isset($values[$k])) {

                $array['value'] = $values[$k];

                $new_elements_data[$key] = $array;

            }

        }

        return $new_elements_data;

    }

    public function download_excel()

    {

        $ids = explode(",", Input::get('ids'));

        $records = OutgoingCall::getAllRecordsByIds($ids);

        if (count($records) < 1) {

            return;

        }

        $rows = array();

        $headings = array();

        foreach ($records[0] as $key => $value) {

            array_push($headings, $key);

        }

        array_push($rows, $headings);

        $rows = array_merge($rows, $records);

        $file = createExcel(array("name" => $this->heading), $rows, 2);

        return json_encode(array("path" => $file));

    }

    public function download_pdf()

    {

        $ids = explode(",", Input::get('ids'));

        $records = OutgoingCall::getAllRecordsByIds($ids, array('name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id', 'minority_group_id', 'refer', 'case_nature_id', 'center_id'));

        if (count($records) < 1) {

            return;

        }

        $rows = array();

        $headings = array();

        foreach ($records[0] as $key => $value) {

            array_push($headings, $key);

        }

        $data = array("heading" => "Outgoing Calls", "headings" => $headings, "records" => $records);

        $html = View::make('layouts.pdf.record', array('data' => $data));

        $file = create_pdf($html, 'Outgoing Calls', true);

        return json_encode(array("path" => $file));

    }

    public function download_report_pdf()

    {

        $data = json_decode(Input::get('json'), true);

        foreach ($data as $key => $value) {

            $value['html'] = html_entity_decode($value['html'], ENT_COMPAT, 'UTF-8');

        }

        $html = View::make('layouts.pdf.report', array('data' => $data));

        return create_pdf($html, 'Outgoing Calls');

    }

    public function center_ajax($city)

    {

        $center = \DB::table('centers')->where('name', 'like', "%$city%")->first();

        $start = explode('/', Input::get('from'));

        $end = explode('/', Input::get('to'));

        $start = $start[2] . '-' . $start[0] . '-' . $start[1];

        $end = $end[2] . '-' . $end[0] . '-' . $end[1];

        $records = getRecordsByDate('outgoing_calls', [$start, $end], $center->id);

        // var_dump($records);exit;

        $display_fields = array('id', 'name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id',

            'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"),

            OutgoingCall::getLabels()), "centers" => array_values(retrieveField(Center::all(), 'name')));

        $records = filterFields('OutgoingCall', $records, $display_fields);

        return json_encode(['records' => $records, 'report_data' => $report_data]);

    }

    public function ajax()

    {

        $start = explode('/', Input::get('from'));

        $end = explode('/', Input::get('to'));

        $start = $start[2] . '-' . $start[0] . '-' . $start[1];

        $end = $end[2] . '-' . $end[0] . '-' . $end[1];

        //$records = getRecordsByDate('outgoing_calls', [$start, $end]);

        if(Auth::check() && Entrust::hasRole('Center_User')){

            $center=Confide::user()->center()->first();

            $records=getRecordsByDate('outgoing_calls',[$start,$end],$center->id);

        }else{

            $records=getRecordsByDate('outgoing_calls',[$start,$end]);

        }

        // var_dump($records);exit;

        $display_fields = array('id', 'name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id',

            'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"),

            OutgoingCall::getLabels()), "centers" => array_values(retrieveField(Center::all(), 'name')));

        $records = filterFields('OutgoingCall', $records, $display_fields);

        return json_encode(['records' => $records, 'report_data' => $report_data]);

    }

    public function ajaxi()

    {

        $records = [];

        if (Auth::check() && Entrust::hasRole('Center_User')) {

            $center = Confide::user()->center()->first();

            $records = OutgoingCall::where('center_id', '=', $center->id)->get();

        } else {

            $records = OutgoingCall::get();

        }

        // var_dump($records);exit;

        $display_fields = array('id', 'name', 'date', 'call_type', 'gender', 'contact', 'priority_group_id',

            'minority_group_id', 'refer', 'case_nature_id', 'center_id');

        $report_data = array("center_column" => 9, "reports_exception" => getValues(array("name", 'date', "contact","center_id", 'call_type', "address", "call_taken_by"),

            OutgoingCall::getLabels()), "centers" => array_values(retrieveField(Center::all(), 'name')));

        $records = filterFields('OutgoingCall', $records, $display_fields);

        $records = array_slice($records, 60);

        return json_encode(['records' => $records, 'report_data' => $report_data]);

    }

}
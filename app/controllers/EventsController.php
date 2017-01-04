<?php
require dirname(dirname(dirname(__FILE__))) . '/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;
class EventsController extends \BaseController {

	private $heading="Events";

	public function index()
	{
		$heading=$this->heading;
		$records=Events::getAllRecords();
		$display_fields=array('title','description','from','to','center_id','events_categorie_id');
		$labels=Events::getLabels();
		$current_route_base='event';
		$create_link='event.create';
		//$iec_link='';
        $iec_link='';
		$delete_link='event.delete';
        $excel_download_link='';
		$pdf_download_link='';
		$report_download_link='';
		$report_data=array();
		$has_reports=false;
		$small_form=true;

		$data=array(

				'heading'=>$heading,
				'fields'=>$display_fields,
				'labels'=>$labels,
				'records'=>$records,
				'records_count'=>count($records),
				'current_route_base'=>$current_route_base,
            'table'=>'event',
            'ajaxi_used'=>'ajaxi',
				'create_link'=>$create_link,
				'iec_link'=>$iec_link,
				'delete_link'=>$delete_link,
				'excel_download_link'=>$excel_download_link,
				'pdf_download_link'=>$pdf_download_link,
				'report_download_link'=>$report_download_link,
				'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
				'has_reports'=>$has_reports,
				'small_form'=>$small_form
			);
        //echo "<pre>";dd($data);

		return View::make('layouts.records.index')->with('data', $data);
	}


    public function calendar()
    {
        //echo"Sucess";exit;
        $heading='Calendar';
        $current_route_base='sycop';
        $f=retrieveField(Center::all(),'name');
        //$events = \DB::table('events')->get();
        $events=Events::getAllRecordsWithColor();

        //echo "<pre>";dd($events);
        $data=array(
            'heading'           =>  $heading,
            'events'            =>  $events,
            'current_route_base'=>  $current_route_base,
            'center_id'         =>  $f,
            'class'             =>  'sycop'
        );
        return View::make('layouts.records.calender')->with('data', $data);
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		 $elements_data             =   $this->generate_form();
		 $data['elements_data']     =   $elements_data;
		 $data['can_import']        =   false;
		 $data['centers']           =   array();
		 $data['submit_url']        =   'event.store';
		 $data['upload_submit_url'] =   'event.excel';
		 $data['heading']           =   $this->heading;
		 $data['go_back']           =   'event.index';

		 return View::make('layouts.records.add')->with('data',$data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$record=new Events;
		$this->save_db($record,'Events/create','Successfully created the record!');
		return Redirect::route('event.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record=Events::find($id);
		if(!$record){return;}

		$data['go_back']='event.index';
		$data['heading']=$this->heading;

		$labels=Events::getLabels();
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

		$record=Events::find($id);
		$elements_data=$this->generate_form($record->toArray());
		$data['elements_data']=$elements_data;
		$data['can_import']=true;
		$data['centers']=retrieveField(Center::all(),'name');
		$data['submit_url']='event.update';
		$data['heading']=$this->heading;
		$data['go_back']='event.index';
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
		
		$record=Events::find($id);
		$this->save_db($record,'event.edit','Successfully updated the record!');
		return Redirect::route('event.index');

	}


		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Events::destroy($id);

		Session::flash('message', 'Successfully deleted  the record');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('event.index');
	}
    public function events_alert()
    {
        /*Mail::send('emails.minty',
            array('title'=>'title',
                'description'   =>  'description',
                'from'          => 'date',
                'to'            => 'to',
                'center_name'   => 'center name'), function($message)
            {
                $message->from('info@accesstojustice.pk', 'Access to Justice Event');
                $message->to('sanaullahAhmad@gmail.com', 'sanaullahAhmad@gmail.com')->subject('Today is an Event in Accesstojustice');
            });
        exit;*/
        $tomorrow_events = DB::table('events')
            ->whereBetween('from', [date('Y-m-d', strtotime(('+1 days'))).' 00:00:00', date('Y-m-d', strtotime(('+1 days'))).' 23:59:59'])
            ->get();
        //var_dump(DB::getQueryLog());
        if($tomorrow_events)
        {
            echo "First if<br>";
            foreach ($tomorrow_events as $event)
            {
                echo "First foreach<br>";
                $events_user = DB::table('users')
                    ->join('center_user', 'center_user.user_id', '=', 'users.id')
                    ->join('centers', 'center_user.center_id', '=', 'centers.id')
                    ->select('users.*', 'center_user.center_id', 'centers.name as center_name')
                    ->where( 'center_user.center_id', '=', $event->center_id)->get();
                //var_dump(DB::getQueryLog());exit;
                if($events_user) {
                    echo "Second if<br>";
                    foreach ($events_user as $userinfot) {
                        echo "Second foreach<br>";
                        //now send mail
                        Mail::send('emails.minty',
                            array('title'=>$event->title,
                                'description'=>$event->description,
                                'from' => date('d F, Y h:m A',strtotime($event->from)),
                                'to' => date('d F, Y h:m A',strtotime($event->to)),
                                'center_name' => $userinfot->center_name), function($message) use ($userinfot)
                                {
                                    $message->from('info@accesstojustice.pk', 'Access to Justice Event');
                                    $message->to($userinfot->email, $userinfot->username)->subject('Today is an Event in Accesstojustice');
                                });
                    }


                    //Get Phone number of this center from center_staff table
                    $staff_phone = DB::table('center_staff')->where( 'center_id', '=', $event->center_id)->get();
                    if($staff_phone)
                    {
                        echo "First if center_staff_phone<br>";
                        foreach ($staff_phone as $phone)
                        {
                            if( $phone->phone != '')
                            {
                                echo " foreach center_staff_phone<br>";
                                $phone_number = str_replace('-','',$phone->phone);
                                $phone_number = str_replace('+','',$phone_number);
                                $phone_number = substr($phone_number, 1);
                                $phone_number = "92".$phone_number;
                                $body = "tomorrow is an event title:".$event->title."  from:".date('d F, Y, h:m A',strtotime($event->from))."  to:".date('d F, Y, h:m A',strtotime($event->to))."  description:".$event->description;
                                $message = urlencode($body);
                                $_url = 'http://api.bizsms.pk/api-send-branded-sms.aspx?username=d-sales-ay@bizsms.pk&pass=d3al3s45786**&text='.$message.'&masking=Demo&destinationnum='.$phone_number.'&language=English';
                                if($_result = file_get_contents($_url)) {
                                    $_result_f = json_decode($_result);
                                    if(!empty($_result_f)){
                                        print_r($_result_f);
                                    } else {
                                        print_r($_result);
                                    }
                                }


                            }
                        }
                    }



                }

                //this is seprate email sending for commasperated emails entered.
                $eachemail= explode(',', $event->email_list);
                foreach ($eachemail as $useremail)
                {
                    if( $useremail != '' && !filter_var($useremail, FILTER_VALIDATE_EMAIL) === false)
                    {
                        echo "seprate email foreach<br>";
                        Mail::send('emails.minty',
                            array('title'=>$event->title,
                                'description'   =>  $event->description,
                                'from'          => date('d F, Y, h:m A',strtotime($event->from)),
                                'to'            => date('d F, Y, h:m A',strtotime($event->to)),
                                'center_name'   => $userinfot->center_name), function($message) use ($useremail)
                            {
                                $message->from('info@accesstojustice.pk', 'Access to Justice Event');
                                $message->to($useremail, $useremail)->subject('Today is an Event in Accesstojustice');
                            });
                    }

                }

                //this is seprate email sending for commasperated emails entered.
                $eachnumber= explode(',', $event->numbers_list);
                foreach ($eachnumber as $usernumber)
                {
                    if( $usernumber != '')
                    {
                        echo "seprate Number SMS foreach<br>";
                        $phone_number = str_replace('-','',$usernumber);
                        $phone_number = substr($phone_number, 1);
                        $phone_number = "92".$phone_number;
                        $body = "tomorrow is an event title:".$event->title."  from:".date('d F, Y, h:m A',strtotime($event->from))."  to:".date('d F, Y, h:m A',strtotime($event->to))."  description:".$event->description;
                        $message = urlencode($body);
                        $_url = 'http://api.bizsms.pk/api-send-branded-sms.aspx?username=d-sales-ay@bizsms.pk&pass=d3al3s45786**&text='.$message.'&masking=Demo&destinationnum='.$phone_number.'&language=English';
                        if($_result = file_get_contents($_url)) {
                            $_result_f = json_decode($_result);
                            if(!empty($_result_f)){
                                print_r($_result_f);
                            } else {
                                print_r($_result);
                            }
                        }
                        /*$sid = 'AC575c6b472a92ec18a4a1578425add842';
                        $token = 'ecc076ad89a9939fcc9468e984ab317e';
                        $client = new Client($sid, $token);
                        $client->messages->create(
                            $usernumber,
                            array(
                                'from' => '+12565884476',
                                'body' => "tomorrow is an event title:".$event->title."  from:".date('d F, Y, h:m A',strtotime($event->from))."  to:".date('d F, Y, h:m A',strtotime($event->to))."  description:".$event->description
                            )
                        );*/
                    }

                }


                //Sending to Default Emails
                $default_emails = DB::table('default_emails')->get();
                if($default_emails)
                {
                    echo "First if Default Emails<br>";
                    foreach ($default_emails as $email) {
                        if( $email->email != '' && !filter_var($email->email, FILTER_VALIDATE_EMAIL) === false) {
                            echo "Default Emails foreach<br>";
                            Mail::send('emails.minty',
                                array('title' => $event->title,
                                    'description' => $event->description,
                                    'from' => date('d F, Y, h:m A', strtotime($event->from)),
                                    'to' => date('d F, Y, h:m A', strtotime($event->to)),
                                    'center_name' => $events_user{0}->center_name), function ($message) use ($email) {
                                    $message->from('info@accesstojustice.pk', 'Access to Justice Event');
                                    $message->to($email->email, $email->name)->subject('Today is an Event in Accesstojustice');
                                });
                        }
                    }
                }


                //Sending to Default Numbers
                $default_numbers = DB::table('default_numbers')->get();
                if($default_numbers)
                {
                    echo "First if Default Numbers<br>";
                    foreach ($default_numbers as $number) {
                        echo "Default Numbers foreach<br>";
                        $phone_number = str_replace('+','',$number->number);
                        $body = "tomorrow is an event title:".$event->title."  from:".date('d F, Y, h:m A',strtotime($event->from))."  to:".date('d F, Y, h:m A',strtotime($event->to))."  description:".$event->description;
                        $message = urlencode($body);
                        $_url = 'http://api.bizsms.pk/api-send-branded-sms.aspx?username=d-sales-ay@bizsms.pk&pass=d3al3s45786**&text='.$message.'&masking=Demo&destinationnum='.$phone_number.'&language=English';
                        if($_result = file_get_contents($_url)) {
                            $_result_f = json_decode($_result);
                            if(!empty($_result_f)){
                                print_r($_result_f);
                            } else {
                                print_r($_result);
                            }
                        }

                    }
                }




            }
        }

    }


	public function save_db($record,$error_redirect,$success_msg){

		$fields=Events::getFillables();
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
			foreach ($fields as $field) {	
				$record->$field=Input::get($field);
			}
			$record->save();

			Session::flash('message', $success_msg);
			Session::flash('alert-class', 'alert-success');
		}
	}

	public function generate_form($values=array()){

        $a=retrieveField(Center::all(),'name');
        if(Auth::check() && Entrust::hasRole('Center_User')){
            $center=Confide::user()->center()->first();
            $a=array($center['id']=>$center['name']);
        }
        $b=retrieveField(EventsCategories::all(),'name');

		$options=array(
            'center_id'=>$a,
            'events_categorie_id'=>$b,
		);

		$labels=Events::getLabels();
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

        /*$elements_data['Color']=array(
            "tag"=>"color","name"=>"color",
            "value"=>"","type"=>"color");*/

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
}
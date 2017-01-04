<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CenterTableSeeder');
	}

}

class CenterTableSeeder extends Seeder {

    public function run(){

    	$data=array(
					'Faisalabad','Hyderabad','Jacobabad',
					'Karachi','Khanewal','Lahore','Multan',
					'Muzaffargarh','Nankana','Sahib','Quetta',
					'Sahiwal','Sialkot','Swat'
			);

		foreach ($data as $d) {
			District::create(array('name'=>$d));
		}


    	$data=array(

    			array(

    				'name'=>'DLAC Faisalabad',
    				'address'=>'Faisalabad',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'1',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Hyderabad',
    				'address'=>'Hyderabad',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'2',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Jacobabad',
    				'address'=>'Jacobabad',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'3',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Karachi',
    				'address'=>'Karachi',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'4',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Khanewal',
    				'address'=>'Khanewal',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'5',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Lahore',
    				'address'=>'Lahore',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'6',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Multan',
    				'address'=>'Multan',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'7',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Faisalabad',
    				'address'=>'Faisalabad',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'8',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Muzaffargarh',
    				'address'=>'Muzaffargarh',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'8',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC  Nankana Sahib',
    				'address'=>' Nankana Sahib',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'9',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Quetta',
    				'address'=>'Quetta',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'10',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			), 
    			array(
    				'name'=>'DLAC Sahiwal',
    				'address'=>'Sahiwal',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'11',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Sialkot',
    				'address'=>'Sialkot',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'12',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			),
    			array(

    				'name'=>'DLAC Swat',
    				'address'=>'Swat',
    				'timings'=>'9 a.m. till 5 p.m',
    				'phone'=>'000000000',
    				'mobile'=>'000000000',
    				'district_id'=>'13',
    				'partner_id'=>'1',
    				'coordinator'=>'Test',
    				'coordinator-number'=>'000000000'
    			)
    		);

		foreach ($data as $d) {
			# code...
			 Center::create($d);
		}  


	
    }

}

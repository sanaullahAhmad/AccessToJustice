<?php

class AggregateController extends \BaseController{



	public function refer_centers(){

		$centers=retrieveField(Center::all(),'name');

		$charts_data=[];
		$records=[];
		$total=0;
		$aggregate_data=[];
		foreach ($centers as $key=>$name) {
			
			$a=IncomingCall::where('refer','!=','No')->where('center_id','=',$key)->count();
			$b=OutgoingCall::where('refer','!=','No')->where('center_id','=',$key )->count();
			$c=LegalAid::where('referred_to','!=','No')->where('center_id','=',$key)->count();

			$records[$name]=$a+$b+$c;
			array_push($charts_data, [$name,$a+$b+$c]);
			$total+=($a+$b+$c);
			$aggregate_data[$name]=["route"=>"refer_pre_index/".$key,"hash"=>""];
		}


		$data=[
			"heading"=>"Center Wise Referrals",
			"records"=>$records,
			"total"=>$total,
			"index_route"=>"refer_pre_index/breakdown",
			"aggregate"=>true,
			"aggregate_data"=>$aggregate_data,
			"charts_data"=>json_encode($charts_data)
		];

		return View::make('layouts.records.pre_index')->with('data', $data);

	}


	public function refer($id=null){
		

		$index_route="";
		$a=0;$b=0;$c=0;
		$center_hash='';

		if($id=="breakdown"){
			$index_route="";	

			$a=IncomingCall::where('refer','!=','No')->count();
			$b=OutgoingCall::where('refer','!=','No')->count();
			$c=LegalAid::where('referred_to','!=','No')->count();
		}
		else{

			$center_id=isset($id)?$id:1;

			if(Entrust::hasRole('Center_User')){
				$center=Confide::user()->center()->first();
				$center_id=$center['id'];
				$center_hash="|Center$".$center['name'];
			}
			else{

				$center=Center::find($center_id);
				$center_hash="Center$".$center['name'];
			}



			$a=IncomingCall::where('refer','!=','No')->where('center_id','=',$center_id)->count();
			$b=OutgoingCall::where('refer','!=','No')->where('center_id','=',$center_id )->count();
			$c=LegalAid::where('referred_to','!=','No')->where('center_id','=',$center_id)->count();	
		}

		


		$records["Incoming Call"]=$a;
		$records["Outgoing Call"]=$b;
		$records["Legal Advice"]=$c;


		$charts_data=[];
		array_push($charts_data, ["Incoming Call",$records["Incoming Call"]]);
		array_push($charts_data, ["Outgoing Call",$records["Outgoing Call"]]);
		array_push($charts_data, ["Legal Advice",$records["Legal Advice"]]);
		 
		$data=[
			"heading"=>"Referrals",
			"records"=>$records,
			"total"=>($a)+($b)+($c),
			"index_route"=>$index_route,
			"aggregate"=>true,
			"aggregate_data"=>["Incoming Call"=>["route"=>"incoming","hash"=>"".$center_hash],"Outgoing Call"=>["route"=>"outgoing","hash"=>"".$center_hash],"Legal Advice"=>["route"=>"legalaid","hash"=>"".$center_hash]],
			"charts_data"=>json_encode($charts_data)
		];

		return View::make('layouts.records.pre_index')->with('data', $data);
	}


	public function support_centers(){

		$centers=retrieveField(Center::all(),'name');

		$charts_data=[];
		$records=[];
		$total=0;
		$aggregate_data=[];

		foreach ($centers as $key=>$name) {
			
			$a=IncomingCall::where('psychosocial_support','=','Yes')->where('center_id','=',$key)->count();
			$b=LegalAid::where('psychosocial_support','=','Yes')->where('center_id','=',$key)->count();
		
			$records[$name]=$a+$b;
			array_push($charts_data, [$name,$a+$b]);
			$total+=($a+$b);
			$aggregate_data[$name]=["route"=>"support_pre_index/".$key,"hash"=>""];
		}


		$data=[
			"heading"=>"Center Wise Psychosocial Support",
			"records"=>$records,
			"total"=>$total,
			"index_route"=>"support_pre_index/breakdown",
			"aggregate"=>true,
			"aggregate_data"=>$aggregate_data,
			"charts_data"=>json_encode($charts_data)
		];

		return View::make('layouts.records.pre_index')->with('data', $data);

	}



	public function support($id=null){

		$index_route="";
		$a=0;$b=0;$c=0;
		$center_hash='';

		if($id=="breakdown"){
			$index_route="";	

			$a=IncomingCall::where('psychosocial_support','=','Yes')->count();
			$b=LegalAid::where('psychosocial_support','=','Yes')->count();

		}
		else{

			$center_id=isset($id)?$id:1;

			if(Entrust::hasRole('Center_User')){
				$center=Confide::user()->center()->first();
				$center_id=$center['id'];
				$center_hash="|Center$".$center['name'];
			}
			else{

				$center=Center::find($center_id);
				$center_hash="|Center$".$center['name'];
			}


			$a=IncomingCall::where('psychosocial_support','=','Yes')->where('center_id','=',$center_id)->count();
			$b=LegalAid::where('psychosocial_support','=','Yes')->where('center_id','=',$center_id)->count();

		}

		$records["Incoming Call"]=$a;
		$records["Legal Advice"]=$b;
	 
		$charts_data=[];
		array_push($charts_data, ["Incoming Call",$records["Incoming Call"]]);
		array_push($charts_data, ["Legal Advice",$records["Legal Advice"]]);
		

		$data=[
			"heading"=>"Psychosocial Support",
			"records"=>$records,
			"total"=>($a)+($b),
			"index_route"=>$index_route,
			"aggregate"=>true,
			"aggregate_data"=>[
						"Incoming Call"=>["route"=>"incoming","hash"=>"Psychosocial_Support_Provided".'$Yes'.$center_hash],
						"Legal Advice"=>["route"=>"legalaid","hash"=>"Psychosocial_Support_Provided_Yes_or_No".'$Yes'.$center_hash]
						],
			"charts_data"=>json_encode($charts_data)
		];

		// dd($data);
		return View::make('layouts.records.pre_index')->with('data', $data);

	}


}

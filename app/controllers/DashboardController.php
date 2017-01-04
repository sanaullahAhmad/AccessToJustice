<?php

class DashboardController extends \BaseController{

	public function index(){

		//$total_referals=(IncomingCall::where('refer','!=','No')->count())
		//			+(OutgoingCall::where('refer','!=','No')->count())+(LegalAid::where('referred_to','!=','No')->count());
		
		$total_referals=(IncomingCall::where('refer','!=','No')->where('call_type','=','First Time')->count())+(LegalAid::where('referred_to','!=','No')->where('first_follow_visit','=','First Time')->count());
							
		
		$total_PSYsupport=(IncomingCall::where('psychosocial_support','=','Yes')->where('call_type','=','First Time')->count())
						+(LegalAid::where('psychosocial_support','=','Yes')->where('first_follow_visit','=','First Time')->count());

		if(Entrust::hasRole('Center_User')){
			$center=Confide::user()->center()->first();

			$a=IncomingCall::where('refer','!=','No')->where('center_id','=',$center['id'])->count();
			$b=OutgoingCall::where('refer','!=','No')->where('center_id','=',$center['id'] )->count();
			$c=LegalAid::where('referred_to','!=','No')->where('center_id','=',$center['id'])->count();

			$total_referals=$a+$b+$c;

			$a=IncomingCall::where('psychosocial_support','=','Yes')->where('center_id','=',$center['id'])->count();
			$b=LegalAid::where('psychosocial_support','=','Yes')->where('center_id','=',$center['id'])->count();
		
			$total_PSYsupport=$a+$b;

		}

		$data=[];

		$startdate = Confide::user()->start_date;
		$enddate = Confide::user()->end_date;
		if(Entrust::hasRole('Center_User')){

			$center=Confide::user()->center()->first();
			$cid=$center['id'];
				$data=array(
					'total_walkins'=>Walkin::where('center_id','=',$cid)->count(),
					'total_incomings'=>IncomingCall::where('center_id','=',$cid)->count(),
					'total_outgoings'=>OutgoingCall::where('center_id','=',$cid)->count(),
					'total_legalaids'=>LegalAid::where('center_id','=',$cid)->count(),
					'total_assistances'=>LegalAssistance::where('center_id','=',$cid)->count(),
					'total_cases'=>CourtCase::where('center_id','=',$cid)->count(),
					'total_referals'=>$total_referals,
					'total_PSYsupport'=>$total_PSYsupport,
					'date_start'=>$startdate,
					'date_end'=>$startdate
			);
		}else{
			$data=array(
				'total_walkins'=>Walkin::all()->count(),
				'total_incomings'=>IncomingCall::all()->count(),
				'total_outgoings'=>OutgoingCall::all()->count(),
				'total_legalaids'=>LegalAid::all()->count(),
				'total_assistances'=>LegalAssistance::all()->count(),
				'total_cases'=>CourtCase::all()->count(),
				'total_referals'=>$total_referals,
				'total_PSYsupport'=>$total_PSYsupport,
				'date_start'=>$startdate,
				'date_end'=>$enddate
			);
		}

		

		return View::make('layouts.dashboard')->with(array('data'=>$data));
	}

}
<?php

class NormalUsersController extends \BaseController {

	
	private $heading="User Accounts";

	public function index()
	{
		$heading=$this->heading;
		$records=User::getAllNormalUsers();
		$display_fields=array('username','email','updated_at');
		$labels=User::getLabels();
		$current_route_base='normalusers';
		$create_link='normalusers.create';
		$iec_link='';
		$delete_link='normalusers.delete';
		$excel_download_link='';
		$pdf_download_link='';
		$report_download_link='';
		$report_data=array();
		$has_reports=false;
		$small_form=true;
		$cant_edit_user=true;

		$labels=array_merge($labels,["updated_at"=>"Last Login"]);

		$data=array(

				'heading'=>$heading,
				'fields'=>$display_fields,
				'labels'=>$labels,
				'records'=>$records,
				'records_count'=>count($records),
				'current_route_base'=>$current_route_base,
                'table'=>'priority_groups',
                'ajaxi_used'=>'ajaxi',
				'create_link'=>$create_link,
				'iec_link'=>$iec_link,
				'delete_link'=>$delete_link,
				'excel_download_link'=>$excel_download_link,
				'pdf_download_link'=>$pdf_download_link,
				'report_download_link'=>$report_download_link,
				'report_data'=>json_encode(array('data'=>$report_data,'has_reports'=>$has_reports)),
				'has_reports'=>$has_reports,
				'small_form'=>$small_form,
				'cant_edit_user'=>$cant_edit_user,
				'block_option'=>true
			);

		return View::make('layouts.records.index')->with('data', $data);
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
		 $data['can_import']=false;
		 $data['centers']=array();
		 $data['submit_url']='users.store';
		 $data['upload_submit_url']='';
		 $data['heading']=$this->heading;
		 $data['go_back']='normalusers.index';

		 return View::make('layouts.records.add')->with('data',$data);
	}


		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		Session::flash('message', 'Successfully deleted  the user');
		Session::flash('alert-class', 'alert-success'); 
		return Redirect::route('normalusers.index');
	}



	public function generate_form($values=array()){

		$centers=retrieveField(Center::all(),'name');

		$elements_data= [
			"Username"=>["tag"=>"input","name"=>'username',
						"value"=>"","type"=>"text"],
			"Email"=>["tag"=>"input","name"=>'email',
						"value"=>"","type"=>"text"],
			"Password"=>["tag"=>"input","name"=>'password',
						"value"=>"","type"=>"password"],
			"Password Confirmation"=>["tag"=>"input",
										"name"=>"password_confirmation","value"=>"",
										"type"=>"password"],
			""=>["tag"=>"input","name"=>'user_type',
						"value"=>"normalrole","type"=>"hidden"]
		];

		
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
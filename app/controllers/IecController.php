<?php

class IecController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index( )
	{
		
		$owner_type=Input::get('owner_type');
		$owner_id=Input::get('owner_id');

		$files=UFile::getFiles($owner_type,$owner_id);

		$data['records']=$files;
		$data['fields']=array('name');
		$data['records_count']=count($files);
		$data['owner_type']=$owner_type;
		$data['owner_id']=$owner_id;
		$data['table_headings']=array('Name');
		$data['download_link']='iec.download_file';
		$data['delete_link']='iec.delete';
		$data['create_link']='iec.create';
		$data['heading']='Files';
		$data['can_upload']=Entrust::can('can_uploadiec');
		
		return View::make('layouts.iec.index')->with('data',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules=array('owner_id'=>'required','owner_type'=>'required',
						'name'=>'required','file'=>'required');

		$extension = Input::file('file')->getClientOriginalExtension();
		$type=Input::file('file')->getMimeType();
		$fileName=microtime().'.'.$extension;
		Input::file('file')->move(__DIR__.'/storage/files/',$fileName);

		$file=new UFile;
		$file->name=Input::get('name');
		$file->owner_id=Input::get('owner_id');
		$file->owner_type=Input::get('owner_type');
		$file->comments=Input::get('comments');
		$file->path='/storage/files/'.$fileName;
		$file->type=$type;

		$file->save();

		Session::flash('message','file has been uploaded successfully');
		Session::flash('alert-class', 'alert-success'); 
	  	return Redirect::route('iec.index',array('owner_type'=>$file->owner_type,'owner_id'=>$file->owner_id));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$file=UFile::find($id);

		$r=unlink(__DIR__.$file->path);
		if($r){
			UFile::destroy($id);	
			Session::flash('alert-class', 'alert-success'); 
			Session::flash('message', 'Successfully deleted  the file');	
		}
		else{
			Session::flash('alert-class', 'alert-danger'); 
			Session::flash('message', 'Ooops... file not deleted.');
		}

		return Redirect::route('iec.index',array('owner_type'=>$file->owner_type,'owner_id'=>$file->owner_id));
	}


	public function download_file()
	{

		$file_id=Input::get('file_id');
		$file=UFile::find($file_id);

		$headers = array(
              'Content-Type:'.$file->type,
            );
	   $ext=explode('.', $file->path);
	    // dd($file->name.'.'.end($ext));
       return Response::download(__DIR__.$file->path, $file->name.'.'.end($ext), $headers);
	}

}

<?php

class UFile extends Eloquent{

	protected $fillable=array('name','path','comments','type','owner_type','owner_id');

	protected $table='files';

	protected function getFiles($owner_type,$owner_id){

		return UFile::whereRaw("owner_type='$owner_type' and owner_id=$owner_id")->get()->toArray();
	
	}

}
?>
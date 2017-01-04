@extends('layouts.default')
@section('flash_messages')
		@if(Session::has('message'))
		<p class="alert {{ Session::get('alert-class','alert-info') }}"> 
			@if(is_array(Session::get('message')))
				@foreach(Session::get('message') as $msg)
					{{$msg}}<br>
				@endforeach
			@else
				{{Session::get('message')}}
			@endif
		@endif
@stop
@section('content_options')

<div >
	<div class="heading pull-left" ><h3>Settings </h3></div>
</div>

@stop
	
@section('content')
	
	<form  action="{{{ URL::to('users/settings') }}}" class="form-horizontal" role="form" method="post">


			<div class="form-group">
				<label for="" class="col-sm-4 control-label">New Password</label>
				<div class="col-sm-3">
					<input type="password" class="form-control input-sm" name="password"/>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Retype New Password</label>
				<div class="col-sm-3">
					<input type="password" class="form-control input-sm" name="password_confirmation"/>
				</div>
			</div>

	

			<div class="form-group">
				<label for="" class="col-sm-4 control-label"></label>
				<div class="col-sm-3">
					<input type="submit" value="Update" class="btn btn-primary" name="sub"/>
				</div>
			</div>

	</form>
	
@stop
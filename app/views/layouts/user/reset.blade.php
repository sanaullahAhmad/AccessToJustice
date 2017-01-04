<!DOCTYPE html>
<html lang="en">

<head>
	<title>Dastageer | Login</title>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/home.css')}}">
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:200' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
</head>
<body>

	<div id="canvas">
		<div id="innver_canvas_left">
		</div>

		<div id="innver_canvas_right">
			<div id="heading">
				<h2>
					Reset Password
				</h2>
					@if(Session::has('message'))
					<span style="margin-top:-30px;color:#DF6262;border:#DF6262 1px solid;background-color:rgba(255, 230, 230, 1);padding:8px" class="alert {{ Session::get('alert-class','alert-info') }}"> 
						@if(is_array(Session::get('message')))
							@foreach(Session::get('message') as $msg)
								{{$msg}}ss<br>
							@endforeach
						@else
							{{Session::get('message')}}
						@endif
					</span><br>
					@endif
					<br>
			<div style="clear:both;"></div>

				<form method="POST" action="{{{ URL::to('/users/reset_password') }}}" accept-charset="UTF-8">
			    <input type="hidden" name="token" value="{{{ $token }}}">
			    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

			    <div class="form-group">
			        <label  class="col-md-3 col-lg-3" for="password">{{{ Lang::get('confide::confide.password') }}}</label>
			        <div class="col-md-8 col-lg-8">
			        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
			    	</div>
			    </div>
			    <div class="form-group">
			        <label class="col-md-3 col-lg-3" for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
			        <div class="col-md-8 col-lg-8">
			        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
			        </div>
			    </div>

			    <div class="form-actions form-group">
			    	<div class="col-md-4 col-lg-4 col-md-offset-2">
			    		<button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
			    	</div>
			        
			    </div>
			</form>

			</div>
			
		</div>
</body>
</html>
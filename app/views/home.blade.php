<!DOCTYPE html>
<html lang="en">

<head>
	<title>Dastageer | Login</title>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/home.css')}}">
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:200' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
</head>
<body>

	<div id="canvas">
		<div id="innver_canvas_left">

		</div>
		<div id="innver_canvas_right">
			<div id="heading">
				<h1>
					Access To Justice 
					<small>Project Login</small>
				</h1>
				
			</div>
					@if(Session::has('message'))
					<span style="margin-top:-30px;color:#DF6262;border:#DF6262 1px solid;background-color:rgba(255, 230, 230, 1);padding:8px" class="alert {{ Session::get('alert-class','alert-info') }}"> 
						@if(is_array(Session::get('message')))
							@foreach(Session::get('message') as $msg)
								{{$msg}}<br>
							@endforeach
						@else
							{{Session::get('message')}}
						@endif
					</span><br>
					@endif
					<br>
			<div style="clear:both;"></div>
			<div id="left">
				<div class="sheading">
					<a href="#database_login">
						<img src="{{asset('assets/images/admin.png')}}" alt="" height="70px;">
						<div class="clear"></div>
						<span style="color:#000;">Database Login</span>
					</a>
				</div>
			</div>

			<div id="right">
				<div class="sheading">
					<a href="#center_login"><img src="{{asset('assets/images/center.png')}}" alt="" height="70px;">
						<div class="clear"></div>
						<span class="center">DLAC Center Login</span>
					</a>
				</div>
			</div>
			<br><br><br>
			<div class="clear"></div>
			<br>
			<a style="float:right;color:#111415;text-decoration:underline;" href="#admin_login">Administrator Login</a>
		</div>
		<div class="clear"></div>
	</div>

	<div id="admin_login" class="modalbg">
		<div class="dialog">
			<a href="#close" title="Close" class="close">X</a>

			<div id = "transparent">
				<!-- <div id = "profilephoto"></div> -->
				<div id = "form">
			
					<div class="clear"></div>
					<div class = "heading1">Administrator Login</div>
					{{ Form::open(array('url' => 'users/login','method'=>'post')) }}

						<input class = "text" type = "text" placeholder = "Email" name="email"/>
						<input class = "text" type = "password" placeholder = "Password" name="password"/>
						<input  type = "hidden" name="u_t" value="admin"/>
						<div class = "smalltext"><a href="#forget_password">Forgot Password</a></div>
						<label for="remember">
							<input type="hidden" name="remember" value="0">
							<input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> Remember me
						</label>
						<div class = "button">
							<input type ="submit" value = "Login"/>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>


	<div id="database_login" class="modalbg">
		<div class="dialog">
			<a href="#close" title="Close" class="close">X</a>

			<div id = "transparent">
				<!-- <div id = "profilephoto"></div> -->
				<div id = "form">
					<img src="http://accesstojustice.pk/_cms/uploads/images/logo/14051077231404798906atj_new_logo.png" class = "logo">
					<br>
					<div class="clear"></div>
					<div class = "heading1">Database Login</div>
					{{ Form::open(array('url' => 'users/login','method'=>'post')) }}

						<input class = "text" type = "text" placeholder = "Email" name="email"/>
						<input class = "text" type = "password" placeholder = "Password" name="password"/>
						<input  type = "hidden" name="u_t" value="normal"/>
						<div class = "smalltext"><a href="#forget_password">Forgot Password</a></div>
						<label for="remember">
							<input type="hidden" name="remember" value="0">
							<input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> Remember me
						</label>
						<div class = "button">
							<input type ="submit" value = "Login"/>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>


<div id="center_login" class="modalbg">
	<div class="dialog">
		<a href="#close" title="Close" class="close">X</a>
		<div id = "transparent">
			<!-- <div id = "profilephoto"></div> -->
			<div id = "form">
				<img src="http://accesstojustice.pk/_cms/uploads/images/logo/14051077231404798906atj_new_logo.png" class = "logo">
				<br>
				<div class = "heading1">Center Login</div>
				{{ Form::open(array('url' => 'users/login','method'=>'post')) }}
					<input class = "text" type = "text" placeholder = "Email" name="email"/>
					<input class = "text" type = "password" placeholder = "Password" name="password"/>
					<input  type = "hidden" name="u_t" value="center"/>
					<div class = "smalltext"><a href="#forget_password">Forgot Password</a></div>
					<label for="remember">
						<input type="hidden" name="remember" value="0">
						<input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> Remember me
					</label>
					<div class = "button">
						<input type ="submit" value = "Login"/>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


<div id="forget_password" class="modalbg">
	<div class="dialog">
		<a href="#close" title="Close" class="close">X</a>
		<div id = "transparent">
			<!-- <div id = "profilephoto"></div> -->
			<div id = "form">
				
				<div class = "heading1">Forget Password</div>
				<br><br>
				{{ Form::open(array('url' => 'users/forgot_password','method'=>'post')) }}
					<div class="input-append input-group">
			            <input class="text form-control" placeholder="Email" type="text" name="email" id="email" value="">
			            <div class="clear:both;"><br></div>
			            <span class="button">
			                <input class="" type="submit" value="Submit">
			            </span>
			        </div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

</body>
</html>
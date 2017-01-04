<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Access To Justice - Project Management</title>
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker-bs3.css')}}" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/nvd3/1.1.15-beta/nv.d3.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">


<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="http://yourjavascript.com/41704451561/chart-min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/print.js')}}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.js')}}"></script> 
</head>
<body>
	
	<div id="menubar">
		@include('includes.navbar')
	</div>
	<div class="clears"></div>
	<div class="container">
		
		<div class="row main">
			<div class="col-md-12">
				<div class="col-md-4 col-md-offset-4">
					@yield('flash_messages')
				</div>	
				
				<div class="col-md-12" id="container-options">
					@yield('content_options')
				</div>
				<div class="clear"></div>
				<div class="transparent" id="container-content">
					
					@yield('content')
				</div>
			</div>

		</div>

		<div id="footer">
			@include('includes.footer')
		</div>
	</div>

<script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
@yield('scripts')

<div id="hidden-div" style="style:hidden;"></div>
</body>
</html>

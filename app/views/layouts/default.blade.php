<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> </html><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	@include('includes.header')
</head>
<body>

<div class="sidebar-full" id="page-container">
	<div id="sidebar">
		<!-- <div id="menubar"> -->
		@include('includes.navbar2')
	</div>
	<!-- <div class="clears"></div> -->
	<!-- <div class="container"> -->
	<div class="main-container" style="margin-left: 200px !important; transition: none 0s ease 0s ;  min-width: 768px; margin-top: 50px">

		<div class="row main">
			<div class="col-md-12">
				<div class="col-md-4 col-md-offset-4">
					@yield('flash_messages')
				</div>

				<div class="col-md-12" id="container-options">
					@yield('content_options')
				</div>
				<div class="clear"></div>
				<div class="white_bg" id="container-content">

					@yield('content')
				</div>
			</div>

		</div>
		<div class="clear"><br></div>
		<div id="footer">
			@include('includes.footer')
		</div>
	</div>

	<script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
	@yield('scripts')

	<div id="hidden-div" style="style:hidden;"></div>
</body>
</html>

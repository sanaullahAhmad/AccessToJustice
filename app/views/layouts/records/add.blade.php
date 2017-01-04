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
	<div class="heading pull-left" ><h3>Add {{{ $data['heading'] }}} </h3></div>
	
	<div class="pull-right" style="padding-top:15px;">
		<a href="{{ URL::route($data['go_back']) }}" class="btn btn-primary" > Go Back</a>
		@if ($data['can_import'])
		<button class="btn btn-default" id="upload_excel">+ Upload File</button>
		@endif
	</div>
	
	@if ($data['can_import'])
	<!-- file upload (import) Modal -->
	<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="">Upload File to Import Data</h4>
				</div>
				<div class="modal-body">
					<div style="height: 200px">

						<form id="" action="{{{ URL::route($data['upload_submit_url']) }}}" method="post" enctype="multipart/form-data">
							
							<div class="alert alert-warning">
							  <strong>Warning!</strong> Pleae note that the format of the date should be YYYY-MM-DD e.g.(2014-12-21)
								Otherwise a default date will be entered.
							</div>

							<div class="form-group">
								<label class="control-lable col-md-2">Center: </label>
								<div class="col-md-10">
									<select class="select" name="center_id" id="center">
										<option value="">Select</option>  
										@foreach ($data['centers'] as $key=>$value)
										    <option value="{{{$key}}}">{{{$value}}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-lable col-md-2">File: </label>
								<div class="col-md-10">
									<input type="file" name="file" class="input-sm col-sm-6"/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<button type="submit" class="btn btn-info" id="file_upload_btn">Upload File</button>
								</div>
							</div>

						</form>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div> 
	<!-- modal ends here --> 

	@endif

</div>

@stop

@section('content')
	
	<form  action="{{{ URL::route($data['submit_url']) }}}" class="form-horizontal" name="myForm" role="form" method="post" onsubmit="return validate_this_form()">

		@foreach($data['elements_data'] as $key=>$element)

			<div class="form-group">
				<label for="" class="col-sm-4 control-label">{{$key}}</label>
				<div class="col-sm-3">
	                
					@if ($element['tag'] === 'input')


							<?php if($element['name']=='time'){ echo ' <div class="bootstrap-timepicker"> '; }?>

	                	<input type="<?php  echo $element['type']; ?>"
							   <?php if($element['name']=='contact' || $element['name']=='lawyer_cell_no'){ echo ' maxlength="12"   onkeypress="return isNumberKey(event);"    onkeydown="return isAddDashContact(this);"'; }?>
							   <?php if($element['name']=='cnic' || $element['name']=='cnin'){ echo ' maxlength="15"   onkeypress="return isNumberKeyCnic(event);"    onkeydown="return isAddDashCnic(this);"'; }?>
							   <?php if($element['name']=='cost' ){ echo '   onkeypress="return isNumberKeyCnic(event);"    onkeydown="return isAddCommaInPrice(this);"'; }?>
							   <?php if($element['name']=='age'){ echo ' maxlength="3"   onkeypress="return isNumberKeyCnic(event);"'; }?>
							   <?php
							   $textarray = array('occupation',
									   'address',
									   'tehsil',
									   'heard_from',
									   'case_nature_id',
									   'action_taken',
									   'occupation',
									   'refer',
									   'relation_with_client',
									   'referred_to',
									   'callback',
									   'ratings',
									   'guardian',
									   'relation_with_guardian',
									   'contact_guardian',
									   'court_name',
									   'lawyer_name',
									   'referred_from',
									   'thumb_impression',
									   'decision' );
							   if( in_array($element['name'], $textarray))
							   { echo '  onblur="return isAlphaOrParen(this);"'; }

							   ?>

							   <?php if(($element['name']=='name' || $element['name']=='call_taken_by') && ($data['submit_url']!='heardabout.store' && $data['submit_url']!='problem.store')){ echo ' onblur="toTitleCase(this)" '; }?>
							   <?php if($element['name']=='time'){ echo ' id="timepicker5"  class="input-small" '; }?>
							   <?php if($element['name']=='from' || $element['name']=='to'){ echo ' class="basic_example_1 form-control"  '; }?>
							   toTitleCase
							   class="form-control input-sm  <?php if($element['name']=='decision_date' && $data['submit_url']=='legalassistance.store'){ echo 'datepickerMonth';} elseif($element['name']=='date' || $element['name']=='decision_date'){ echo 'datepicker';}?>"
							   <?php if($element['name']=='decision_date'){ ?> value="-"  <?php } else { ?> value="{{$element['value']}}"  <?php  }?>

							   name="{{{$element['name']}}}"
							   <?php if($element['name']=='date' || $element['name']=='decision_date' || $element['name']=='time'){ echo 'readonly';}?> required />

								<?php if($element['name']=='time'){ echo ' <i class="icon-time"></i></div> '; }?>

	            	@elseif ($element['tag'] === 'select')
					    <select class="col-sm-3 select" name="{{{$element['name']}}}" >
					    	@foreach ($element['options'] as $key=>$value)
					    		<option value="{{$key}}">{{$value}}</option>
					    	@endforeach
					    </select>

					@elseif ($element['tag'] === 'select_options')
						<select class="col-sm-3 select" name="{{{$element['name']}}}" >

							@foreach ($element['options'] as $key=>$value)
								<optgroup label="{{$key}}">
									@foreach ($value as $op_id=>$op_name)
										<option value="{{$op_id}}">{{$op_name}}</option>
									@endforeach
							@endforeach
						</select>

					@elseif ($element['tag'] === 'color')
						<input name="{{ $element['name'] }}" type="{{  $element['type'] }}" value="{{ $element['value'] }}" />
					@endif
	            </div>
			</div>

		@endforeach

			<div class="form-group">
				<label for="" class="col-sm-4 control-label"></label>
				<div class="col-sm-3">
					<input type="submit" value="Submit" class="btn btn-primary" name="sub"/>
				</div>
			</div>

	</form>
@stop

@section('scripts')


	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

	<link href="{{ url() }}/assets/css/timepicker.less" type="text/css" rel="stylesheet">
	<script src="{{ url() }}/assets/js/bootstrap-timepicker.js"></script>

	<script type="text/javascript" src="{{ url() }}/assets/js/bootstrap-datetimepicker.js"></script>
	<link rel="stylesheet" href="{{ url() }}/assets/css/bootstrap-datetimepicker.css" />



	<script type="text/javascript">
		function validate_this_form()
		{
			var x = document.forms["myForm"]["date"].value;


			var selects = document.getElementsByTagName('select');
			var sel;
			var relevantSelects = '';
			var mycount =1;
			for(var z=0; z<selects.length; z++){
				sel = selects[z];

				if(sel.value == "" && sel.name !== "center_id"){
					//relevantSelects.push(sel);
					relevantSelects = relevantSelects+'  ('+mycount+') '+' '+sel.name;
					mycount++;
				}
			}
			if (x == "") {
				alert("Date must be filled out");
				return false;
			}
			else if(relevantSelects != "")
			{
				alert(relevantSelects+"  must be selected");
				return false;
			}
			else {
				return true;
			}

		}
		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			console.log(charCode);
			if (charCode != 46 && charCode != 45 && charCode > 31
					&& (charCode < 48 || charCode > 57))
				return false;

			return true;
		}
		function isNumberKeyCnic(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			console.log(charCode);
			if (charCode != 46 && charCode != 45 && charCode > 31
					&& (charCode < 48 || charCode > 57))
				return false;

			return true;
		}
		function toTitleCase(str)
		{
			var ress = str.value.toLowerCase().split(' ').map(i => i[0].toUpperCase() + i.substring(1)).join(' ');
			//alert(ress);
			str.value = ress;
			isAlphaOrParen(str);
		}
		function isAddDashCnic(str)
		{
			if(str.value.length == 5 || str.value.length == 13)
			 {
				 str.value=str.value+'-';
			 }
		}
		function isAddCommaInPrice(str)
		{
			if(str.value.length == 2 || str.value.length == 6 || str.value.length == 10 || str.value.length == 14 || str.value.length == 18 || str.value.length == 22)
			{
				str.value=str.value+',';
			}
		}
		function isAddDashContact(str)
		{
			if(str.value.length == 4)
			{
				str.value=str.value+'-';
			}
		}

		function isAlphaOrParen(inputtxt)
		{
			//var letters = /^[A-Za-z ]+$/;
			var nums = /^[0-9]+$/;
			var numsspace = /^[0-9 ]+$/;
			if(inputtxt.value.match(nums))
			{
				inputtxt.value='';
				return false;
			}
			else
			{
				if(inputtxt.value.match(numsspace))
				{
					inputtxt.value='';
					return false;
				}
				else {
					return true;
				}
			}
		}

		bind_file_upload_popup();
		$('.basic_example_1').datetimepicker({
			viewMode: 'days',
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		var today = new Date();
		var lastDate = new Date(today.getFullYear(), today.getMonth(0)-1, 31);
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'/*,
			 startDate: '-1m',
			 endDate: lastDate*/
		});
		$('.datepickerMonth').datepicker({
			format: 'yyyy-mm'
		});
		$('#timepicker5').timepicker({
			//showInputs: false,
			minuteStep: 5,
			//defaultTime:false,
			/*showSeconds:true,
			maxHours:24,
			showMeridian:false*/
		});
	</script>
@stop
<style type="text/css" id="less:bootstrap-timepicker-css-timepicker">/*!
 * Timepicker Component for Twitter Bootstrap
 *
 * Copyright 2013 Joris de Wit
 *
 * Contributors https://github.com/jdewit/bootstrap-timepicker/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
	.bootstrap-timepicker {
		position: relative;
	}
	.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu {
		left: auto;
		right: 0;
	}
	.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:before {
		left: auto;
		right: 12px;
	}
	.bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:after {
		left: auto;
		right: 13px;
	}
	.bootstrap-timepicker .input-group-addon {
		cursor: pointer;
	}
	.bootstrap-timepicker .input-group-addon i {
		display: inline-block;
		width: 16px;
		height: 16px;
	}
	.bootstrap-timepicker-widget.dropdown-menu {
		padding: 4px;
	}
	.bootstrap-timepicker-widget.dropdown-menu.open {
		display: inline-block;
	}
	.bootstrap-timepicker-widget.dropdown-menu:before {
		border-bottom: 7px solid rgba(0, 0, 0, 0.2);
		border-left: 7px solid transparent;
		border-right: 7px solid transparent;
		content: "";
		display: inline-block;
		position: absolute;
	}
	.bootstrap-timepicker-widget.dropdown-menu:after {
		border-bottom: 6px solid #FFFFFF;
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		content: "";
		display: inline-block;
		position: absolute;
	}
	.bootstrap-timepicker-widget.timepicker-orient-left:before {
		left: 6px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-left:after {
		left: 7px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-right:before {
		right: 6px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-right:after {
		right: 7px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-top:before {
		top: -7px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-top:after {
		top: -6px;
	}
	.bootstrap-timepicker-widget.timepicker-orient-bottom:before {
		bottom: -7px;
		border-bottom: 0;
		border-top: 7px solid #999;
	}
	.bootstrap-timepicker-widget.timepicker-orient-bottom:after {
		bottom: -6px;
		border-bottom: 0;
		border-top: 6px solid #ffffff;
	}
	.bootstrap-timepicker-widget a.btn,
	.bootstrap-timepicker-widget input {
		border-radius: 4px;
	}
	.bootstrap-timepicker-widget table {
		width: 100%;
		margin: 0;
	}
	.bootstrap-timepicker-widget table td {
		text-align: center;
		height: 30px;
		margin: 0;
		padding: 2px;
	}
	.bootstrap-timepicker-widget table td:not(.separator) {
		min-width: 30px;
	}
	.bootstrap-timepicker-widget table td span {
		width: 100%;
	}
	.bootstrap-timepicker-widget table td a {
		border: 1px transparent solid;
		width: 100%;
		display: inline-block;
		margin: 0;
		padding: 8px 0;
		outline: 0;
		color: #333;
	}
	.bootstrap-timepicker-widget table td a:hover {
		text-decoration: none;
		background-color: #eee;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		border-color: #ddd;
	}
	.bootstrap-timepicker-widget table td a i {
		margin-top: 2px;
		font-size: 18px;
	}
	.bootstrap-timepicker-widget table td input {
		width: 25px;
		margin: 0;
		text-align: center;
	}
	.bootstrap-timepicker-widget .modal-content {
		padding: 4px;
	}
	@media (min-width: 767px) {
		.bootstrap-timepicker-widget.modal {
			width: 200px;
			margin-left: -100px;
		}
	}
	@media (max-width: 767px) {
		.bootstrap-timepicker {
			width: 100%;
		}
		.bootstrap-timepicker .dropdown-menu {
			width: 100%;
		}
	}
</style>
@extends('layouts.default')



<style>
	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
</style>

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
		<div class="heading pull-left" ><h3> {{{ $data['heading'] }}} </h3></div>
		<div class="pull-right" style="padding-top:15px;">
			<a class="btn btn-default" href="{{url()}}/{{$data['current_route_base'] }}/pre_index">&laquo; Back</a>
		</div>

	</div>

@stop

@section('content')



	<div class="clear"></div>
	@if(!Entrust::hasRole('Normal_User') && !Entrust::hasRole('Center_User'))
		<div class="col-md-12" style="margin-bottom: 15px;">
			<div style="float:left; margin-right:20px;"><strong>Select Center: </strong></div>
			<div class="calender_legends" >
				<select class="col-sm-3 select" name="center_record" onchange="loadcenterevents(this.value)">
					<option value="All" <?php if(isset($_GET['center_record']) && $_GET['center_record']=='All'){ echo "selected";} ?> >All</option>
					@foreach ($data['center_id'] as $key=>$value)
						<option value="{{$key}}" <?php if(isset($_GET['center_record']) && $_GET['center_record']==$key){ echo "selected";} ?> >{{$value}}</option>
					@endforeach
				</select>
			</div>
		</div>
	@endif

	<div id="table-container">

		<div id='calendar'></div>

	</div>

@stop

@section('scripts')
	<link href="{{ url('') }}/assets/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
	{{--<link href="{{ url('') }}/assets/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" />--}}
	<script src="{{ url('') }}/assets/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<script>
		function loadcenterevents(center_id)
		{
			window.location.href='{{ url('') }}/calendar?center_record='+center_id
		}
		$(document).ready(function()
		{
			$('#calendar').fullCalendar(
					{
						theme: true,
						header:
						{
							left: 'prev,next today',
							center: 'title',
							right: 'month,agendaWeek,agendaDay'
						},
						defaultDate: '<?php echo date('Y-m-d')?>',
						editable: true,
						eventLimit: true, // allow "more" link when too many events
						events: [
								<?php foreach($data['events'] as $event){
								?>
									{
										title: '<?php echo $event['title'].' ,'.$event['center_id'];?>',
										start: '<?php echo date('Y-m-d', strtotime($event['from']));?>T<?php echo date('H:i:s', strtotime($event['from']));?>',
										end: '<?php echo date('Y-m-d', strtotime($event['to']));?>T<?php echo date('H:i:s', strtotime($event['to']));?>',
										color: '<?php echo $event['events_categorie_id'] ;?>'
									},
								<?php }?>
							/*{
								title: 'All Day Event',
								start: '2016-12-01'
							},
							{
								title: 'Long Event',
								start: '2016-12-07',
								end: '2015-12-10'
							},
							{
								id: 999,
								title: 'Repeating Event',
								start: '2016-12-09T16:00:00'
							},
							{
								id: 999,
								title: 'Repeating Event',
								start: '2016-12-16T16:00:00'
							},
							{
								title: 'Conference',
								start: '2016-12-11',
								end: '2016-12-13'
							},
							{
								title: 'Meeting',
								start: '2016-12-12T10:30:00',
								end: '2016-12-12T12:30:00'
							},
							{
								title: 'Lunch',
								start: '2016-02-12T12:00:00'
							},
							{
								title: 'Meeting',
								start: '2016-02-12T14:30:00'
							},
							{
								title: 'Happy Hour',
								start: '2015-12-12T17:30:00'
							},
							{
								title: 'Dinner',
								start: '2016-12-12T20:00:00'
							},
							{
								title: 'Birthday Party',
								start: '2016-12-13T07:00:00'
							},
							{
								title: 'Click for Google',
								url: 'http://google.com/',
								start: '2016-12-28'
							}*/]
					});
		});
	</script>
@stop
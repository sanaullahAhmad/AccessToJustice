@extends('layouts.default')

@section('content_options')

<div >
	<div class="heading pull-left" ><h3>Add {{{ $data['heading'] }}} </h3></div>
	<div class="pull-right" style="padding-top:15px;">

		 <a href="{{ URL::route($data['go_back']) }}" class="btn btn-primary" > Go Back</a>
		 
	</div>
</div>

@stop
	
@section('content')
	<table class="table">
		<tbody>

			@foreach ($data['rows'] as $key=>$value)
				@if(strtolower($key)=='date')
					<?php	$value=date('Y-m-d',$value);	?>
				@endif
				<tr>
					<td>  {{$key}}	</td>
					<td>  {{$value}}  </td>
				</tr>
	
			@endforeach
		</tbody>
	</table>
	
@stop

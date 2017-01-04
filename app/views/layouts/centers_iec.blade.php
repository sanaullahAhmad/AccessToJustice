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
	<div class="heading pull-left" ><h3>{{{ $data['heading'] }}} </h3></div>
</div>

@stop
	
@section('content')
	<table class="table">
		<tbody>
			<thead>
				<th>Center</th>
				<th>Organiztion</th>
			</thead>
			@foreach ($data['centers'] as $center)
				<tr>
					<td> <a href="{{{ URL::action($data['iec_link'],array('owner_type'=>$data['current_route_base'],'owner_id'=>$center['id'])) }}}"> {{$center['name']}} </a></td>
					<td>  {{$center['partner_id']}}  </td>
				</tr>
	
			@endforeach
		</tbody>
	</table>
	
@stop
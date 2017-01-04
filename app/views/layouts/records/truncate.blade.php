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


@section('content')
	


	<div class="clear"></div>
	<div id="table-container">

	<table id="record-table">
		
		<thead>
		<tr>
		<td>Table</td>		
		<td>Action</td>
		</tr>
		</thead>

		

		@foreach ($data as $key=>$record)
		
			    <tr>

			    	<td>
			    		
			    		{{$record}}
			    	</td>

					<td >
				
						@if(!Entrust::hasRole('Normal_User')||!Entrust::hasRole('Center_User'))
						<a class="action-icon empty-table" href="tyfd_okj/{{$key}}"><img src="{{asset('assets/images/delete-1-icon[1].png')}}"></a>
						
		                @endif

					</td>
			    </tr>
		
		@endforeach

	</table>
	</div>
	<div id="summaryTablesContainer">
		<div id="summaryInnerContainer">

		</div>
	</div>
@stop

@section('scripts')

	<script type="text/javascript">
		load_data_table('{}');
	</script>
@stop
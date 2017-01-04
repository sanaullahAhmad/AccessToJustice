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
	<div class="heading pull-left" ><h3>Project Timeline Settings </h3></div>
</div>

@stop
	
@section('content')
	
	{{ Form::open(
					array(
						'route' => array($data['submit_url'], $data['record_id']), 
						'method' => 'PUT',
						'class'=>"form-horizontal", 
						'role'=>"form"
						)
				) }}


				@foreach($data['elements_data'] as $key=>$element)

			<div class="form-group">
				<label for="" class="col-sm-4 control-label">{{$key}}</label>
				<div class="col-sm-3">
	                
					@if ($element['tag'] === 'input')
						@if($element['name']=='date')
							<?php	$element['value']=date('Y-m-d',$element['value']);	?>
						@endif
						@if($element['value']=='')
							<?php $element['value']='-'; ?>
						@endif
	                	<input type="date" class="form-control input-sm" name="{{{$element['name']}}}" value="{{{ $element['value'] }}}"/>
	            	@elseif ($element['tag'] === 'select')
					    <select class="col-sm-3 select" name="{{{$element['name']}}}">
					    	@foreach ($element['options'] as $key=>$value)
					    		
					    		@if($key==trim($element['value']))
					    		<option selected="selected" value="{{$key}}">{{$value}}</option>
					    		@else
					    		<option value="{{$key}}">{{$value}}</option>
					    		@endif
					    	@endforeach
					    </select> 
					@endif
	            </div>
			</div>

		@endforeach
		

			<div class="form-group">
				<label for="" class="col-sm-4 control-label"></label>
				<div class="col-sm-3">
					<input type="submit" value="Update" class="btn btn-primary" name="sub"/>
				</div>
			</div>

	</form>
	
@stop
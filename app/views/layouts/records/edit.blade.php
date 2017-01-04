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
	<div class="heading pull-left" ><h3>Edit {{{ $data['heading'] }}} </h3></div>
	<div class="pull-right" style="padding-top:15px;">
		<a href="{{ URL::route($data['go_back']) }}" class="btn btn-primary" > Go Back</a>
	</div>
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
	                	<input
								<?php if($element['name']=='from' || $element['name']=='to'){ echo ' class="basic_example_1 form-control"  '; }?>
								type="{{{$element['type']}}}" class="form-control input-sm" name="{{{$element['name']}}}" value="{{{ $element['value'] }}}"/>
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

	<script type="text/javascript" src="{{ url() }}/assets/js/bootstrap-datetimepicker.js"></script>
	<link rel="stylesheet" href="{{ url() }}/assets/css/bootstrap-datetimepicker.css" />
	<script type="text/javascript">
		bind_file_upload_popup();
		$('.basic_example_1').datetimepicker({
			viewMode: 'days',
			format: 'YYYY-MM-DD HH:mm:ss'
		});
	</script>
@stop
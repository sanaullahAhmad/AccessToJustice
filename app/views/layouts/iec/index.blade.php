@extends('layouts.default')

@section('flash_messages')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
@stop

@section('content_options')

<div >
	<div class="heading pull-left" ><h3> Information, Education & Communication Files</h3></div>
	
	@if(!Entrust::hasRole('Normal_User'))
	<div class="pull-right" style="padding-top:15px;">
		<button id="upload_file" class="btn btn-primary">Upload File</button>
	</div>
	@endif
</div>
</div>

<!-- file upload (import) Modal -->
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="courtCasesFileUploadLabel">Upload File </h4>
			</div>
			<div class="modal-body">
				<div style="height:150px">
					<form id="import_form" action="" method="post" enctype="multipart/form-data">
						<div class="form-group" style="height:40px">
							<input type="hidden" name="owner_id" value="{{$data['owner_id']}}">
							<input type="hidden" name="owner_type" value="{{$data['owner_type']}}">
							<label class="control-lable col-md-2">Name: </label>
							<div class="col-md-10">
								<input type="text" id="title" name="name" class="input-sm col-sm-6"/>
							</div>
						</div>
						<div class="form-group" style="height:40px">
							<label class="control-lable col-md-2">File: </label>
							<div class="col-md-10">
								<input type="file" id="file" name="file" class="input-sm col-sm-6"/>
							</div>
						</div>
						<div class="form-group" style="height:70px">
							<label class="control-lable col-md-2">Comments: </label>
							<div class="col-md-10">
								<textarea type="text" name="comments" class="input-sm col-sm-6"/></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-4 control-label"></label>
							<div class="col-sm-3">
								
								<input type="submit" value="Submit" class="btn btn-primary" name="sub">
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

@stop

@section('content')

<table id="record-table">

	<thead>
		@foreach ($data['table_headings'] as $heading)
		<th>{{{ $heading }}} </th>
		@endforeach

		<th>Actions</th>
	</thead>

	@foreach ($data['records'] as $record)

	<tr>

		
			    	@foreach ($data['fields'] as $field)
						    <td>
						    	{{{	$record[$field] }}}
							</td>
					@endforeach
		 
		<td width="15%">
			<a class="action-icon" href="{{{ URL::route($data['download_link'],array('file_id'=>$record['id'])) }}}"><img src="{{asset('assets/images/download.png')}}"></a>
			 {{ Form::open(array('url' => 'iec/'. $record['id'], 'class' => 'pull-right','onsubmit'=>'return delete_popup(this);')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('', array('class' => 'action-icon del-record')) }}
            {{ Form::close() }}	

		</td>

	</tr>

	@endforeach

</table>
@stop

@section('scripts')

<script type="text/javascript">

$('#record-table').DataTable();
bind_any_file_upload_popup();
</script>
@stop
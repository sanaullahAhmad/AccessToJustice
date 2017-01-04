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
		<div class="heading pull-left" ><h3> Joint Networking Meetings </h3></div>
		<div class="pull-right" style="padding-top:15px;">
		<button id="btn-dwn-excel" class="btn btn-primary"data-placement="top" data-toggle="tooltip" data-original-title="Download Excel File" href="#" data-url="{{{ URL::route('meeting.download_excel') }}}">Download Excel</button>
		@if(!Entrust::hasRole('Normal_User'))

		<a class="btn btn-default" href="{{ 	URL::route('meeting.create') 	}}">Add New Meeting</a>
		
		@endif
		</div>

	</div>
	
@stop

@section('content')

	<div class="clear"></div>
	<div id="table-container">

	<table id="record-table">
 
  	<thead>
  		<tr>
  			<th>District</th>
  			<th>Dates</th>
  			<th>Quarter</th>
  			<th width="70px">Actions</th>
  		</tr>
  		<tr id="after-head">
			
			<td></td>
  			<td></td>
  			<td></td>
  			<td width="70px"></td>
			</tr>
  	</thead>
  		@foreach($meetings as $meeting)
  		<tr data-id="{{$meeting['id']}}" >
  			<td>{{$meeting['district_id']}}</td>
  			<td>{{$meeting['date']}}</td>
  			<td>{{$meeting['quater']}}</td>
  			<td width="70px">
  				
	<a class="action-icon" href="{{{ URL::action('iec.index',array('owner_type'=>'meeting','owner_id'=>$meeting['id'])) }}}"><img src="{{asset('assets/images/folder-generic(1).png')}}"></a>
	@if(Entrust::hasRole('Admin'))
  				<a class="action-icon pull-right" href="{{{ URL::to('meeting/'.$meeting['id'].'/edit') }}}"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>
				  		 
  				{{ Form::open(array('url' => 'meeting/'. $meeting['id'], 'class' => 'pull-right','onsubmit'=>'return delete_popup(this);')) }}
		                    {{ Form::hidden('_method', 'DELETE') }}
		                    {{ Form::submit('', array('class' => 'action-icon del-record')) }}
		         {{ Form::close() }}
@endif
		       
  			</td>
  			
  		</tr>
  		@endforeach
  		<tfoot>
			<th></th>
  			<th></th>
  			<th></th>
  			<th width="70px"></th>
		</tfoot>
  	</table>
  </div>
  
  
<div id="downloadmodal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> Download Processing</h4>
      </div>
      <div class="modal-body">
           	<div class="ui center aligned segment">
      			<img width="200px" height="200px" src="{{{asset('assets/images/loading.gif')}}}" />
		    </div>
		    <div class="ui center aligned segment">
		   		<div class=" ui header">Please wait while we process the file for you. You will be alterted once your file is ready.</div> 
		    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="downloadreadymodal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Download Ready</h4>
      </div>
      <div class="modal-body">
           	<div> <a  id="dwnldlink" class="btn btn-primary" href="">Click here to download the file</a></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('scripts')

<script type="text/javascript">
function get_filtered_data_ids(){

	var nodes=$('#record-table tbody>tr');
	var ids=[];

	nodes.each(function(n,o){

		var id=$(o).attr('data-id');
		ids.push(id);
	});

	return ids;
}

$('#btn-dwn-excel').click(function(){
		
	$('#downloadmodal').modal();
	var ids=get_filtered_data_ids();
	$('#btn-dwn-excel').prop('disabled', true);
	send_post_ajax($('#btn-dwn-excel').attr('data-url'),{ids:ids.join()},function(data){
		
		data=JSON.parse(data); 
		$('#downloadmodal').modal('hide');
		 $('#btn-dwn-excel').prop('disabled', false);
		$('#dwnldlink').attr('href','download'+'?filename='+data.path);
		$('#downloadreadymodal').modal();
	});

	//document.location.href=url;

});

var table=$('#record-table').DataTable({"aLengthMenu": [15,20,30,50,100]});

$("#record-table tfoot th").each( function ( i,o ){

			if(i>2) return;
			var headingId;
			 
			if($("#record-table tfoot th").size()-1==i){return;}

			headingId=$('#record-table thead th').eq(i).html();
			$('#record-table tfoot th').eq(i).html('');
 	
			headingId=headingId.trim(' ').replace(/\s/g, "_").replace('(','').replace(')','').replace(',','');
			
			var thead_th=$('#after-head td').eq(i);
			var header=$('#record-table thead th').eq(i).html();
			var top_select = $('<select  style="max-width:60px;" id="'+headingId.trim(' ').replace('/','')+'"><option value=""></option></select>')
			.appendTo( $(thead_th))
			.on( 'change', function () {

				var val = $(this).val();
				table.column( i )
				.search( val ? '^'+$(this).val()+'$' : val, true, true)
				.draw();
			});


			var select = $('<select  style="max-width:60px;" id="'+headingId.trim(' ').replace('/','')+'"><option value=""></option></select>')
			.appendTo( $(this).empty() )
			.on( 'change', function () {

				var val = $(this).val();
				table.column( i )
				.search( val ? '^'+$(this).val()+'$' : val, true, true )
				.draw();
			});
			
			column_counts={};
			table.column( i ).data().sort().each( function ( d, j ) {
					column_counts[d]=(column_counts[d]||0)+1;
			});

			table.column( i ).data().unique().sort().each( function ( d, j ) {
				
				top_select.append( '<option value="'+d+'">'+d+'('+column_counts[d]+')</option>');
				select.append( '<option value="'+d+'">'+d+'('+column_counts[d]+')</option>');
			});

});



</script>
	
@stop
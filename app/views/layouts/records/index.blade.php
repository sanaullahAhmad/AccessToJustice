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
		@if($data['has_reports'])
			<div id="warning" class="alert alert-warning">
				<strong>Alert!</strong> Please wait, while
				is fully loaded.
			</div>
		@endif
		<div class="heading pull-left" ><h3> {{{ $data['heading'] }}} </h3></div>
		<div class="pull-right" style="padding-top:15px;">
			<a class="btn btn-default" href="{{url()}}/{{$data['current_route_base'] }}/pre_index">&laquo; Back</a>
			@if(!Entrust::hasRole('Normal_User')  || $data['current_route_base']=='event')

				<a class="btn btn-default" href="{{ 	URL::route($data['create_link']) 	}}">Add {{	$data['heading']	}}</a>

			@endif

			@if($data['has_reports'])



				<div class="btn-group">
					<button id="summary-btn" class="btn btn-default" data-url="{{$data['create_link'] }}">Detail Summary</button>
					<button id="reports-btn" class="btn btn-default" data-url="{{$data['create_link'] }}">Reports</button>
				</div>
			@endif
		</div>

	</div>

@stop

@section('content')

	@if($data['has_reports'])
		<div style="float:right;margin-bottom:5px;">
			<div class="dwn-btns">
				<div name="daterange" id="daterange"  class="btn btn-success toolt">
					<script>
						var start=moment('{{ ProjectDate::find(1)->start}}').format('MMMM DD, YYYY');
						var end=moment('{{ ProjectDate::find(1)->end}}').format('MMMM DD, YYYY');
						document.write(start +" - "+ end);
					</script>
				</div>
				@include('layouts.daterange.record')
				<a id="btn-dwn-excel" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Download Excel File" href="#" data-url="{{{ URL::route($data['excel_download_link']) }}}">Excel</a>
				<a id="btn-dwn-pdf" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Download Pdf File" href="#" data-url="{{{ URL::route($data['pdf_download_link']) }}}">PDF</a>
				<a id="btn-dwn-pdf" class="btn btn-primary toolt" onclick="callCrudAction();"  data-original-title="Delete Selected" href="#" >Delete Selected</a>
			</div>
			<div style="display:none;" class="dwn-btns">
				@if(isset($data['group_analysis']))
					<a class="btn btn-primary" href="{{ 	URL::to($data['group_analysis']) 	}}">Priority Group Analysis</a>
				@endif
				<button id="btn-rpt-pdf" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Download PDF" data-url="{{{  URL::route($data['report_download_link']) }}}">PDF</button>
				<!-- <button id="btn-print-view" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Print">Print View</button> -->
			</div>
		</div>
	@endif

	<div class="clear"></div>
	<div id="table-container">

		<table id="record-table">

			<thead>
			@foreach ($data['fields'] as $field)
				<th>{{{ $data['labels'][$field] }}} </th>

			@endforeach

			<th>
				Actions
				<span>
					<input type="checkbox" id="check_all_checkbox"  onClick="toggle(this)" >
				</span>
			</th>

			<tr id="after-head">

				@foreach ($data['fields'] as $field)
					<td> </td>

				@endforeach

				<td> </td>
			</tr>
			</thead>

			<canvas id="canvas" width="1000px" height="600px" style="display:none;"></canvas>

			@foreach($data['records'] as $record)

				<?php
				//echo "<pre>";dd($data['records']);exit;
				?>

				<tr>

					@foreach ($data['fields'] as $field)

						@if($field=='date')
							<?php	$record[$field] =date('Y-m-d',$record[$field]);	?>
						@endif
						<td>
							{{{	trim($record[$field]) }}}
						</td>
					@endforeach

					<td data-id="{{$record['id']}}">
						@if(!$data['small_form'])
							<a class="action-icon" href="{{{  URL::to($data['current_route_base'].'/'.$record['id']) }}}"><img src="{{asset('assets/images/viewreport.png')}}"></a>
							<a class="action-icon" href="{{{ URL::action($data['iec_link'],array('owner_type'=>$data['current_route_base'],'owner_id'=>$record['id'])) }}}"><img src="{{asset('assets/images/folder-generic(1).png')}}"></a>
						@endif
						<?php /* $created_at = date('Ymd', strtotime($record['created_at'])); print_r($record);exit;&& $created_at>20151001)*/ ?>
						@if(!Entrust::hasRole('Normal_User') && !Entrust::hasRole('Center_User') )
							@if(!isset($data[' ']) )
								<a class="action-icon" href="{{{ URL::to($data['current_route_base'].'/'.$record['id'].'/edit') }}}"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>
							@endif

							@if(isset($data['block_option']))
								<a class="action-icon" route="<?php echo $data['current_route_base'] ?>" blocked="{{$record['blocked']}}" id="block{{$record['id']}}" onclick="return block_popup(this);" href="#"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>
							@endif

							<span>
							<input type="checkbox" value="{{$record['id']}}" class="single_record_select">
						</span>
							{{ Form::open(array('url' => $data['current_route_base'].'/'. $record['id'], 'class' => 'pull-right','onsubmit'=>'return delete_popup(this);')) }}
							{{ Form::hidden('_method', 'DELETE') }}
							{{ Form::submit('', array('class' => 'action-icon del-record')) }}
							{{ Form::close() }}
						@endif

					</td>
				</tr>

			@endforeach

			<tfoot>
			@foreach ($data['fields'] as $field)
				<th>{{{ $data['labels'][$field] }}} </th>
			@endforeach

			<th></th>
			</tfoot>

		</table>
	</div>
	@if(isset($data['type']) && $data['type']=='incoming')
		<div>Note: * Caller Identity Unknown</div>
	@endif
	<div id="summaryTablesContainer">

		<br>
		<div id="summaryInnerContainer">

		</div>
	</div>
	<div class="donload ui modal">
		<i class="close icon"></i>
		<div class="header">
			Download Excel
		</div>
		<div class="content">
			<div class="ui center aligned segment">
				<img width="200px" height="200px" src="{{{asset('assets/images/loading.gif')}}}" />
			</div>
			<div class="ui center aligned segment">
				<div class=" ui header">Please wait while we process the file for you. </div>

			</div>
		</div>
		<div class="actions">
			<div class="ui button">
				Cancel
			</div>
			<div class="ui button">
				Okay
			</div>
		</div>
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
					<div> <a data-route="{{$data['current_route_base'].'/download'}}" id="dwnldlink" class="btn btn-primary" href="">Click here to download the file</a></div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop

@section('scripts')

	<script type="text/javascript">
		function toggle(source) {
			checkboxes = document.getElementsByClassName('single_record_select');
			for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			}
		}
		function callCrudAction() {
			if (confirm('Are you sure to delete selected records?')) {
				var checkedValues = $('.single_record_select:checked').map(function() {
					return this.value;
				}).get();
				queryString = {
					table:'{{$data['table'] }}',
					ids:checkedValues
				}

				jQuery.ajax({
					url: "{{ url() }}/walkin/multiple_delet",
					data:queryString,
					type: "POST",
					success:function(data)
					{
						window.location.reload();
					},
					error:function (){}
				});
			}
			else
			{
				return false;
			}
		}



		function load_data_table(options){
			//alert('load_data_table');
			table=$('#record-table').DataTable({
				"aLengthMenu": [30,50,100,300,500],
				"columnDefs": [
						<?php $t_row = sizeof($data['fields']);
							for($i=0; $i<$t_row; $i++)
								{
									?>
									{ className: "column_<?php echo $i;?>", "targets": [ <?php echo $i;?>] },
									<?php
								}
						?>

				]
			});
			$('#summaryTablesContainer').hide();
			if(!options['has_reports']){return;}
			$('#summary-btn').on('click',function(){

				$('#summaryTablesContainer').hide();
				$('#record-table_wrapper').fadeIn('fast');
				$(this).prop('disabled', true);
				$('#reports-btn').prop('disabled', false);
				$('.dwn-btns').eq(1).hide();
				$('.dwn-btns').eq(0).show();
			});
			$('#reports-btn').on('click',function(){
				$('#record-table_wrapper').hide();
				$('#summaryTablesContainer').fadeIn('fast');
				$(this).prop('disabled', true);
				$('#summary-btn').prop('disabled', false);
				$('.dwn-btns').eq(0).hide();
				$('.dwn-btns').eq(1).show();
			});
			options=options['data'];
			build_datatable(options);
		}



		$(document).ready( function () {
			bind_file_download_excel();
			bind_file_download_pdf();
			bind_file_download_charts_pdf();
			load_data_table(JSON.parse('{{$data['report_data']}}',true));
			bind_from_to_daterange("#from","#to");



			send_ajax("{{url()}}/{{$data['current_route_base'] }}/{{$data['ajaxi_used'] }}",{}
					,function(data){

						data=JSON.parse(data,true);
						addData=[];
						for(i=0;i<data['records'].length;i++){

							var id=data['records'][i].shift();
							var curent_route='{{ $data['current_route_base'] }}';
							var iec_link='{{{ $data['iec_link'] }}}'+'?owner_type='+curent_route+'&amp;owner_id='+id;
							var delete_link=curent_route+'/'+id;
							var edit_link=curent_route+'/'+id+'/edit';

							var record=data['records'][i];

							for(var j=0;j<record.length;j++){

								if(parseInt(record[j])>10000000){
									record[j]=moment(record[j], 'X').format('YYYY-MM-DD');
								}

								record[j]='<td>'+record[j].trim(' ')+'</td>';
							}

							var td='<td>'+
									'<div  data-id="'+id+'"></div>'+
									'<a class="action-icon esh" href="'+curent_route+'/'+id+'"><img src="{{asset('assets/images/viewreport.png')}}"></a>'+
									'<a class="action-icon" href="'+iec_link+'"><img src="{{asset('assets/images/folder-generic(1).png')}}"></a>'+
									@if(!Entrust::hasRole('Normal_User') && !Entrust::hasRole('Center_User'))
											'<a class="action-icon" href="'+edit_link+'"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>'+
									'<span><input type="checkbox" value="'+id+'" class="single_record_select"></span>'+
									'{{ Form::open(array("url" =>$data['current_route_base'].'/customid', "class" => "pull-right","onsubmit"=>"return delete_popup(this);")) }}'+
									'{{ Form::hidden("_method", "DELETE") }}'+
									'{{ Form::submit("", array("class" => "action-icon del-record")) }}'+
									'{{ Form::close() }}'+
									@endif
											'</td>';
							td=td.replace('customid',id);
							data['records'][i].push(td);
							// $('#record-table tbody').append('<tr>'+data['records'][i]+'</tr>');

							addData.push(data['records'][i]);
						}

						table.rows.add(addData);
						table.draw()
						options=data['report_data'];
						$('#after-head').children('td').html('');
						$('#summaryTablesContainer').html('');
						$('#summaryTablesContainer').html('<div id="summaryInnerContainer"></div>');
						if(data['records'].length > 0){
							//this array is not empty
							build_datatable(options);
						}

						$('.select').selectBoxIt();
						hashchange();
						$('#warning').hide();
						var chartwidth = $(".placeholder .highcharts-container").width();
						chartwidth =chartwidth;
						$('table#report').css('width',chartwidth+'px')
					});
			bind_daterange(function(){
				var inputs=$('.customdaterange').find('input');
				if(inputs.eq(0).val()=='' || inputs.eq(1).val()==''){return;}
				var data={'from':inputs.eq(0).val(),'to':inputs.eq(1).val()};

				var n=moment(inputs.eq(0).val()).format('MMMM DD, YYYY')+' - '+moment(inputs.eq(1).val()).format('MMMM DD, YYYY');
				console.log(n,inputs);
				$('#daterange').text(n);

				<?php
				if($data['ajaxi_used']=='ajaxi')
					{
					?>
					send_ajax("{{url()}}/{{$data['current_route_base'].'/ajax' }}",data,function(data){
					<?php
					}
					else
					{
						$ajixxi = explode('/', $data['ajaxi_used']);

					?>
					send_ajax("{{url()}}/{{$data['current_route_base'].'/center_ajax/'.$ajixxi[1] }}",data,function(data){
						<?php
                    }
                    ?>



                        reset_and_hide_picker();
						$('#record-table').dataTable().fnClearTable();
						$('#record-table').dataTable().fnDestroy();
						// console.log(data);

						data=JSON.parse(data,true);
						for(i=0;i<data['records'].length;i++){

							var id=data['records'][i].shift();
							var curent_route='{{ $data['current_route_base'] }}';
							var iec_link='{{{ $data['iec_link'] }}}'+'?owner_type='+curent_route+'&amp;owner_id='+id;
							var delete_link=curent_route+'/'+id;
							var edit_link=curent_route+'/'+id+'/edit';


							var record=data['records'][i];

							for(var j=0;j<record.length;j++){

								if(parseInt(record[j])>10000000){
									record[j]=moment(record[j], 'X').format('YYYY-MM-DD');
								}

								record[j]='<td>'+record[j].trim(' ')+'</td>';
							}

							var td='<td>'+
									'<div  data-id="'+id+'"></div>'+
									'<a class="action-icon esh" href="'+curent_route+'/'+id+'"><img src="{{asset('assets/images/viewreport.png')}}"></a>'+
									'<a class="action-icon" href="'+iec_link+'"><img src="{{asset('assets/images/folder-generic(1).png')}}"></a>'+
									@if(!Entrust::hasRole('Normal_User') && !Entrust::hasRole('Center_User'))
									'<a class="action-icon" href="'+edit_link+'"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>'+
									'<span><input type="checkbox" value="'+id+'" class="single_record_select"></span>'+
									'{{ Form::open(array("url" =>$data['current_route_base'].'/', "class" => "pull-right","onsubmit"=>"return delete_popup(this);")) }}'+
									'{{ Form::hidden('_method', 'DELETE') }}'+
									'{{ Form::submit('', array('class' => 'action-icon del-record')) }}'+
									'{{ Form::close() }}'+
									@endif
									'</td>';

							var url=$(td).find('form').attr('action');
							$(td).find('form').attr('action',url+id)
							data['records'][i].push(td);
							$('#record-table tbody').append('<tr>'+data['records'][i]+'</tr>');

							// table.row.add(data['records'][i]).draw();
							// console.log("oee",$('#record-table').find('tr'));
							// // alert("");
							// $('#record-table').find('tr').last().children('td').last().attr('data-id',id);
						}

						$('#after-head').children('td').html('');
						$('#summaryTablesContainer').html('');
						$('#summaryTablesContainer').html('<div id="summaryInnerContainer"></div>');
						load_data_table({data:data['report_data'],has_reports:true});
						$('.select').selectBoxIt();
						hashchange();

					});
				});

				hashchange();
			});

	</script>
@stop
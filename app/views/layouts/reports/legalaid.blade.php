@extends('layouts.default')

@section('flash_messages')
	@if(Session::has('message'))
	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
	@endif
@stop

@section('content')
	
	<div style="float:right;margin-bottom:5px;">
		<div style="text-align: right;" class="dwn-btns">
			<div name="daterange" id="daterange"  class="btn btn-success toolt">
						<script>
							var start=moment([moment().format('YYYY'), parseInt(moment().format('MM')) - 1]).format('MMMM DD, YYYY');
							var end=moment().format('MMMM DD, YYYY');
							document.write(start +" - "+ end);
						</script>
			</div>
			<button id="btn-rpt-pdf" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Download PDF" data-url="">PDF</button>
			<button id="btn-print-view" class="btn btn-primary toolt" data-placement="top" data-toggle="tooltip" data-original-title="Download Excel">Excel</button>
		</div>
	</div>

	<div class="clear"></div>

	<div style="display:none;" id="graph" class="graph">
		<div class="row">
			<div id="chart_container" class="placeholder col-md-10">
			</div>
			<div style="height: 150px;" class="legend col-md-2">
				<div class="percentage_change">
					<span>699</span><h4>Percentage Change</h4>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-content">
		<table id="report">
		<thead></thead>
		<tbody></tbody>
		</table>
	</div>

	<div id="table-container">
		
	</div>

	@include('layouts.daterange.general')

@stop

@section('scripts')

	<script type="text/javascript">

		var report_title='General Analysis';

		bind_from_to_daterange("#from","#to");
		
		bind_daterange(function(){
			
			var label=$('.customdaterange .active').html();
		 	var inputs=$('div[data-type='+label+']').find('input');
		 	if(inputs.eq(0).val()=='' ||inputs.eq(1).val()==''){return;}
		 	var data={'from':inputs.eq(0).val(),'to':inputs.eq(1).val()};
			
			var n=moment(inputs.eq(0).val()).format('MMMM DD, YYYY')+' - '+moment(inputs.eq(1).val()).format('MMMM DD, YYYY');
			$('#daterange').text(n);

		 	send_ajax("{{$data['current_route_base'].'/ajax' }}",data,function(data){
		 		
		 		reset_and_hide_picker();
		 		table.clear().draw();
		 		 // console.log(data);

		 		data=JSON.parse(data,true);
		 		for(i=0;i<data['records'].length;i++){

			 		var id=data['records'][i].shift();
			 		var curent_route='{{ $data['current_route_base'] }}';
			 		var iec_link='{{{ $data['iec_link'] }}}'+'?owner_type='+curent_route+'&amp;owner_id='+id;
			 		var delete_link=curent_route+'/'+id;
			 		var edit_link=curent_route+'/'+id+'/edit';

			 		var td='<td data-id="'+id+'">'+
							'<a class="action-icon" href="'+curent_route+'/'+id+'"><img src="{{asset('assets/images/viewreport.png')}}"></a>'+
							'<a class="action-icon" href="'+iec_link+'"><img src="{{asset('assets/images/folder-generic(1).png')}}"></a>'+
							'<a class="action-icon" href="'+edit_link+'"><img src="{{asset('assets/images/edit-icon[1].png')}}"></a>'+ 
						 '{{ Form::open(array('url' => '+delete_link+', 'class' => 'pull-right','onsubmit'=>'return delete_popup(this);')) }}'+
		                    '{{ Form::hidden('_method', 'DELETE') }}'+
		                    '{{ Form::submit('', array('class' => 'action-icon del-record')) }}'+
		                '{{ Form::close() }}'+
					'</td>';

			 		
			 		data['records'][i].push(td);
			 		var record=data['records'][i];

			 		for(var j=0;j<record.length;j++){
			 			
			 			if(parseInt(record[j])>10000000){
			 				record[j]=moment(record[j], 'X').format('YYYY-MM-DD');
			 			}
			 		}

			 		table.row.add(data['records'][i]).draw();	
		 		}
		 		
		 		$('#summaryTablesContainer').html('');
		 		$('#summaryTablesContainer').html('<div id="summaryInnerContainer"></div>');
		 		build_datatable(data['report_data']);
		 		$('.select').selectBoxIt();

		 	});
		});


	function prepare_report_chart(label,d){

		var dsets=Array();

		for(var title in d){

			var datapoints=Array();
			// console.log(d[title],label);
			for(var l in label){
				// console.log(l)
				if(label[l]!='Percentage Change'){
					datapoints.push(d[title][label[l]]);	
				}
				
			}

			var r = getRandomInt(0, 255);
		    var g = getRandomInt(0, 255);
		    var b = getRandomInt(0, 255);

			dsets.push({
					name: title,
		            data: datapoints

			});

		}
		
		return dsets;
	}

	</script>
@stop
@extends('layouts.default')

@section('content_options')

	<div >
		<div class="heading pull-left" ><h3> Priority Group Analysis </h3></div>

	</div>
	
@stop

@section('content')
	

	@foreach($data as $key=>$array)
	 
		<div style="100%" id="graph-{{str_replace(' ','',$key)}}" class="graph">
			<div class="row">
				<div style="width:100%" id="chart_container" class="placeholder col-md-10">
				</div>
			</div>
		</div>

		<div class="tab-content">
		<table style="width:100%" id="report">
		<thead>
			<tr>
			
				<th>Name</th>
				<th>Count</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($array as $key=>$value)
				<tr>
				<td> {{$value[0]}} </td>
				<td> {{$value[1]}}</td>	
				 </tr>
			@endforeach						
		</tbody>
		</table>
		</div>
		<br><br>
	@endforeach
@stop

@section('scripts')

	<script type="text/javascript">
		
		$(document).ready(function(){

			var json=JSON.parse('{{$json}}',true);
			console.log(json);
			for(var group in json){

				console.log(group.replace(' ',''));

				$('#graph-'+replaceAll(' ','',group)).highcharts({
		            chart: {
		            	type: 'pie',
			            options3d: {
			                enabled: true,
			                alpha: 45,
			                beta: 0
			            },
		            },
		            title: {
		                text: group
		            },
		            tooltip: {
		                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		            },
		            plotOptions: {
		                pie: {
		                    allowPointSelect: true,
		                    depth:35,
		                    cursor: 'pointer',
		                    dataLabels: {
		                        enabled: true,
		                        // formatter: '{series.name}: <b>{point.percentage:.1f}%</b>'
		                    },
		                    showInLegend: true
		                }
		            },
		            legend: {
				        labelFormat:'{name}: <b>{percentage:.1f}%</b>',
				    },
		            series: [{
		                type: 'pie',
		                name: group,
		                data: json[group]
		            }]
		        });

			}

		});

	</script>
@stop

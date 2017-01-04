@extends('layouts.default')

@section('content_options')

	<div >
		<div class="heading pull-left" ><h3> {{{ $data['heading'] }}}<small style="font:16px;">&nbsp;&nbsp;&nbsp;({{ date('F d, Y',strtotime(ProjectDate::find(1)->start))}}  -  {{ date('F d, Y',strtotime(ProjectDate::find(1)->end))}}) </small></h3></div>
<a class="btn btn-default pull-right" href="{{URL::to('/')}}">&laquo; Back to dashboard</a>
	</div>
	
@stop

@section('content')
	
		
	<div style="100%" id="graph" class="graph">
		<div class="row">
			<div style="width:100%" id="chart_container" class="placeholder col-md-10">
			</div>
		</div>
	</div>

	<div class="tab-content">
	<table style="width:100%" id="report">
	<thead>
		<tr>
			@foreach($data['records'] as $key=>$value)
			<th>{{ trim(str_replace('DLAC','',$key))}}</th>
			@endforeach

			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		@foreach($data['records'] as $key=>$value)
			
			@if(isset($data['aggregate']))
				<?php //echo "<pre>";dd($data['aggregate_data']);
					if( strpos($data['aggregate_data'][$key]['hash'], 'Center$DLAC ') !== false)
						{
							?>
							<td> <a href="{{URL::to($data['aggregate_data'][$key]['route'])}}/center/{{ trim(str_replace('Center$DLAC ','',$data['aggregate_data'][$key]['hash'])) }}"> {{$value}} </a></td>
							<?php
						}
						else
						{
					?>
							<td> <a href="{{URL::to($data['aggregate_data'][$key]['route'])}}/{{ trim(str_replace(array('Psychosocial_Support_Provided$Yes|Center$DLAC ','Psychosocial_Support_Provided_Yes_or_No$Yes|Center$DLAC '),'',$data['aggregate_data'][$key]['hash'])) }}"> {{$value}} </a></td>

					<?php
						}
					?>
			@else
			<td> <a href="{{URL::to($data['index_route'])}}/center/{{ trim(str_replace('DLAC','',$key)) }}"> {{$value}} </a></td>
			@endif
		@endforeach

		<td> <a href="{{URL::to($data['index_route'])}}"> {{$data['total']}} </a></td>	
		</tr>
		
	</tbody>
	</table>
	</div>
@stop

@section('scripts')

	<script type="text/javascript">
		
		 $('#chart_container').highcharts({
            chart: {
            	type: 'pie',
	            options3d: {
	                enabled: true,
	                alpha: 45,
	                beta: 0
	            },
	            
               
            },
            title: {
                text: 'Overview of Decentralized Data'
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
                          style: {
					        textShadow: ''
					    }
                    },
                    showInLegend: true
                }
            },
            legend: {
		        labelFormat:'{name}: <b>{percentage:.1f}%</b>',

		    },
            series: [{
                type: 'pie',
                name: 'Decentralized {{$data['heading']}} records',
                data: JSON.parse('{{$data['charts_data']}}',true)
            }]
        });

	</script>
@stop
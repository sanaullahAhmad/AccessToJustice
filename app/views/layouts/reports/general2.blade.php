@extends('layouts.default')

@section('flash_messages')
	@if(Session::has('message'))
	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
	@endif
@stop

@section('content')
	
	<div style="float:right;margin-bottom:5px;">
		<div style="text-align: right;" class="dwn-btns">
			<!-- <img width="20%" src="{{ asset('assets/images/click-here-arrow.png')}}"> -->
			<div name="daterange" id="daterange"  class="btn btn-success toolt">Click Here for Reports</div>
			
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

		bind_daterange(function(){

	 	var label=$('.customdaterange .active').html();
	 	var selects=$('div[data-type='+label+']').find('select');
	 	var data={};
	 	console.log(selects);
	 	switch(label){
	 		case 'Weekly':
	 			$('#daterange').text('Weekly Report( Month:'+selects.eq(0).val()+' Year:'+selects.eq(1).val());
	 			data={'type':'weekly','m':selects.eq(0).val(),'y':selects.eq(1).val()};
	 			break;
	 		case 'Monthly':
	 			$('#daterange').text('Monthly Report( Year:'+selects.eq(0).val());
	 			data={'type':'monthly','y':selects.eq(0).val()};
	 			break;
	 		case 'Quaterly':
	 			$('#daterange').text('Quaterly Report( Year:'+selects.eq(0).val());
	 			data={'type':'quaterly','y':selects.eq(0).val()};
	 			break;
	 		case 'Bi-Quaterly':
	 			$('#daterange').text('Bi-Quaterly Report( Year:'+selects.eq(0).val());
	 			data={'type':'biquaterly','y':selects.eq(0).val()};
	 			break;
	 		case 'Yearly':
	 			$('#daterange').text('Yearly Report( From:'+selects.eq(0).val()+' To:'+selects.eq(1).val());
	 			data={'type':'yearly','sy':selects.eq(0).val(),'ey':selects.eq(1).val()};
	 			break;
	 	}

	 	$('#graph').hide();
		send_ajax("general_ajax",data,function(data){

			// console.log(data);return;
			data=JSON.parse(data,true);
			
			var html='',hhtml='';

			hhtml+='<tr><thead><th style="text-align: left; width: 100%" class="header">Activity</th>';

			var labels=Array();
			for(var title in data){

				for(var heading in data[title]){

					hhtml+='<th style="text-align:left; width: 100%" class="header">'+heading+'</th>';
					if(heading!='percentage_change'){labels.push(heading)}
				}
				break;
			}

			hhtml+='</thead></tr>';

			total_change=0;
		
			for(var title in data){

				// var title=Object.keys(record);
				html+='<tr>';
				html+='<td>'+title+'</td>';
				for(var heading in data[title]){

					html+='<td>'+data[title][heading]+'</td>';
					if(heading=='Percentage Change'){
						total_change+=parseInt(data[title][heading].replace('%',''));
					}
				}
				html+='</tr>';
			}

			charts_data=prepare_report_chart(labels,data);
			console.log(charts_data);
			
			

			// var line = new Chart(document.getElementById("chart").getContext("2d")).Line(charts_data);
			$('.percentage_change span').text(total_change+'%');
			$('#graph').show();
			$('#report thead').html(hhtml);
			$('#report tbody').html(html);

			//$('#chart_container>div').width('800px');
			//$('#chart_container>div').height('200px');
		});
	 	
	 	reset_and_hide_picker();
	 });




	function create_pie_chart(data){

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
                        // formatter: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    showInLegend: true
                }
            },
            legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0
		    },
            series: data
        });
	}

	function create_line_chart(data){

			$('#chart_container').highcharts({
			        title: {
			            text: report_title,
			            x: -20 //center
			        },
			        xAxis: {
			            categories: labels
			        },
			        yAxis: {
			            title: {
			                text: 'Records'
			            },
			            plotLines: [{
			                value: 0,
			                width: 1,
			                color: '#808080'
			            }]
			        },
			        legend: {
			            layout: 'vertical',
			            align: 'right',
			            verticalAlign: 'middle',
			            borderWidth: 0
			        },
			        series: data
			    });

	}

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
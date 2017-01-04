@extends('layouts.default')

@section('flash_messages')
	@if(Session::has('message'))
	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
	@endif
@stop

@section('content_options')
	
	<div >
	<div class="heading pull-left" ><h3>Analytical Reports</h3></div>
	</div>

@stop

@section('content')

<style type="text/css">

.panel::-webkit-scrollbar {width:12px;}
.panel::-webkit-scrollbar-track {-webkit-box-shadow: inset 0 0 6px rgba(196, 196, 196,0.4);background:#eee;}
.panel::-webkit-scrollbar-thumb {background:rgb(182, 182, 182);-webkit-box-shadow:inset 0 0 6px rgb(115,115,115,0.8);border:1px solid #606060;border-radius:3px;}
.panel::-webkit-scrollbar:horizontal{height:12px;}
.panel::-webkit-scrollbar-thumb:window-inactive {background:rgba(175, 175, 175, 0.8);-webkit-box-shadow:inset 0 0 6px rgb(115,115,115,0.6);}

#report th, #report td {
	white-space: nowrap;
}

</style>

	<button class="btn btn-primary pull-right" type="button" onclick="hide_show_filters()">
	  Show/Hide Filters
	</button>
	<div class="clear"><br></div>
	<div class="panel" id="filter">
	  <div class="panel-heading">
	    <h3 class="panel-title">Report Filters</h3>
	  </div>
	  <div class="panel-body">

	  	<div class="col-md-2">
	  	<div class="panel panel-default">
		  <div class="panel-heading">Range</div>
		  <div class="panel-body">    
		    <ul id="range" class="nav nav-pills nav-stacked">
			
		   		<?php /*?><li role="presentation"><a data-value="weekly" href="#">Weekly</a></li> <?php */?>
		   		<li role="presentation"><a data-value="monthly" href="#">Monthly</a></li>
		   		<li role="presentation"><a data-value="quaterly" href="#">Quarterly</a></li>
		   		<li role="presentation"><a data-value="yearly" href="#">Yearly</a></li>

			</ul>
		  </div>
		</div>
	  	</div>

	 <div class="col-md-2">
	  	<div class="panel panel-default" style="max-height: 281px;overflow-y: auto;">
		  <div class="panel-heading">Centers</div>
		  <div class="panel-body">
		    <ul id="center"  class="nav nav-pills nav-stacked">
		    	@if(!Entrust::hasRole('Center_User'))
		   			<li role="presentation"><a data-value="-1" href="#">All</a></li>
		   		@endif

		   		@foreach($centers as $center)
		   			<li role="presentation"><a data-value="{{array_search($center, $centers)}}" href="#">{{$center}}</a></li>
		   		@endforeach
			</ul>
		  </div>
		</div>
	  	</div>

	  <div class="col-md-3">
	  	<div class="panel panel-default" style="max-height: 281px;overflow-y: auto;">
		  <div class="panel-heading">Forms</div>
		  <div class="panel-body">    
		     <ul id="form"  class="nav nav-pills nav-stacked">
		     	@if(!Entrust::hasRole('Center_User'))
		   		<li role="presentation"><a data-value="-1" href="#">All</a></li>
		   		@endif
		   		@foreach($forms as $form)
		   			<li role="presentation"><a data-value="{{array_search($form, $forms)}}" href="#">{{$form}}</a></li>
		   		@endforeach
		   		
			</ul>
		  </div>
		</div>
	  	</div>	   

	    <div class="col-md-2">
	  	<div class="panel panel-default">
		  <div class="panel-heading">Report</div>
		  <div id="report"  class="panel-body">    
		   
		   	<ul class="nav nav-pills nav-stacked">	
		   		<li role="presentation"><a data-value="trend" href="#">Trend Analysis</a></li>
		   		<li role="presentation" class="active"><a data-value="compare" href="#">Comaparative Analysis</a></li>
			</ul>
		  </div>
		</div>
	  	</div>

	  		@include('layouts.reports.date_range')
		   	
		</div>

	  </div>

	  	<div class="clear"><br></div>

	   	<div style="display:none;" id="filterbar" class="row">
		  <div class="col-md-2"><b>Range: </b><span>weekly</span></div>
		  <div class="col-md-2"><b>Center: </b><span>All</span></div>
		  <div class="col-md-2"><b>Form: </b><span>All</span></div>
		  <div class="col-md-2"><b>Report: </b><span>compare</span></div>
		</div>

		<div class="col-md-offset-5 col-md-2"><button id="gen_btn" class="btn btn-success">Generate</button> <span class="loading" style="display:none;"><img width="30px" height="30px" src="{{asset('assets/images/ajax-loader.gif')}}"></span></div>
	</div>

	</div>

	<div class="clear"><br></div>
	<br>
	<div class="row">
		
			 
			 
			<div style="width:100%;"  id="chart_container" class="placeholder"></div>
			 
	 
			<div class="clear"></div>
			<div class="tab-content">
				<table id="report">
				<thead></thead>
				<tbody></tbody>
				</table>
			</div>


	</div>

<input id="chart-title" value="" type="hidden"/>

<script type="text/javascript">
	
	var filters={

		range:"weekly",
		center:"-1",
		form:"-1",
		report:"compare",
		date:{from:null,to:null},

	};

	dates_updates();
	date_hide_all();

	function date_update_from(){

		var selects=$('#range-from select');
		var week=selects.eq(0).val();
		var month=selects.eq(1).val();
		var quater=selects.eq(2).val();
		var year=selects.eq(3).val();

		filters.date.from={w:week,m:month,q:quater,y:year};

	}

	function date_update_to(){

		var selects=$('#range-to select');
		var week=selects.eq(0).val();
		var month=selects.eq(1).val();
		var quater=selects.eq(2).val();
		var year=selects.eq(3).val();
		filters.date.to={w:week,m:month,q:quater,y:year};
	}

	function date_hide_all(){

		$('.weekly').hide();
		$('.monthly').hide();
		$('.quaterly').hide();
		$('.yearly').hide();
	}


	function update_from_to(){

		// $('#range-to').hide();
		// $('#range-from').hide();

		// if(filters.report=='compare') {$('#range-to').show();$('#range-from').show();}
		// else $('#range-from').show();

	}

	function update_lower_filterbar(){

		// var divs=$('#filterbar div');
		// // $('#center').find('li[data-value='+filters.range+']').eq(0).val()
		// divs.eq(0).find('span').eq(0).html(filters.range);
		// divs.eq(1).find('span').eq(0).html($('#center').find('li.active').eq(0).text());
		// divs.eq(2).find('span').eq(0).html($('#form').find('li.active').eq(0).text());
		// divs.eq(3).find('span').eq(0).html(filters.report);

		var title=$('#form').find('li.active').eq(0).text()+' Form - '+$('#center').find('li.active').eq(0).text()+' Center '+filters.range.substr(0,1).toUpperCase()+filters.range.substr(1,filters.range.length-1)+' Report';
		$('#chart-title').val(title);

		console.log(filters);
	}

	function show_only_relevant(){

		$('.'+filters.range).show();
		console.log(filters.range);
	}

	function apply_rangefilter(ele){
		 filters.range=ele.find('a').eq(0).attr('data-value');date_hide_all();show_only_relevant();$('#range li').removeClass('active'); ele.addClass('active');update_lower_filterbar()
	}
	function apply_centerfilter(ele){
		filters.center=ele.find('a').eq(0).attr('data-value');$('#center li').removeClass('active'); ele.addClass('active');update_lower_filterbar()
	}
	function apply_formfilter(ele){
		 filters.form=ele.find('a').eq(0).attr('data-value');$('#form li').removeClass('active'); ele.addClass('active');update_lower_filterbar()
	}
	function apply_reportfilter(ele){

		filters.report=ele.find('a').eq(0).attr('data-value'); update_from_to();$('#report li').removeClass('active'); ele.addClass('active');update_lower_filterbar()
	}

	function create_bar_chart(data,labels){

		$('#chart_container').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: $('#chart-title').val()
	        },
	        xAxis: {
	            categories: labels,
	            allowDecimals: false,
	            title: {
	                text: null
	            }
	        },
	        yAxis: {
	            min: 0,
	            title: {
			    	text: 'Records'
			    },
	            allowDecimals: false,
	            labels: {
	                overflow: 'justify'
	            }
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        plotOptions: {
	            bar: {
	                dataLabels: {
	                    enabled: true,
	                    style: {
					        textShadow: ''
					    }
	                }
	            }
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'top',
	            x: -40,
	            y: 100,
	            floating: true,
	            borderWidth: 1,
	            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
	            shadow: true
	        },
	        credits: {
	            enabled: false
	        },
	        series: data
	    });

		console.log();
	}


	function create_line_chart(data,labels){

			$('#chart_container').highcharts({
			        title: {
			            text: $('#chart-title').val(),
			            x: -20 //center
			        },
			        xAxis: {
			            categories: labels,
			            allowDecimals: false,
			        },
			        yAxis: {
			        	allowDecimals: false,
			        	min:0,
			            title: {
			                text: 'Records'
			            },
			            plotLines: [{
			                value: 0,
			                width: 1,
			                color: '#808080'
			            }]
			        },
			        plotOptions: {
			            line: {
			                dataLabels: {
			                    enabled: true,
			                    style: {
					        textShadow: ''
					    }
			                }
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

	function prepare_report_chart(label,d){

		console.log(d);
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

			dsets.push({
					name: title,
		            data: datapoints

			});

		}
		
		return dsets;
	}

	function prepare_report_chart2(label,d){

		console.log(d);
		var dsets=Array();
		var datapoints=Array();

		for(var title in d){

			
			// console.log(d[title],label);
			for(var l in label){
				// console.log(l)
				if(label[l]!='Percentage Change'){
					if(typeof datapoints[label[l]] == 'undefined'){	datapoints[label[l]]=Array();	}
					
					datapoints[label[l]].push(d[title][label[l]]);
				}
				
			}

		}

		var labels=[];

		for (var i in datapoints) {

			dsets.push({
					name: i,
		            data: datapoints[i]
			});
		};
		
		console.log(dsets);
		return [dsets,Object.keys(d)];
	}

	function dates_updates(){
		date_update_from();
		date_update_to();
		update_lower_filterbar();
	}

	$('#range li').on('click',function(){apply_rangefilter($(this)) });
	$('#center li').on('click',function(){ apply_centerfilter($(this)) });
	$('#form li').on('click',function(){apply_formfilter($(this)) });
	$('#report li').on('click',function(){ apply_reportfilter($(this));date_hide_all();show_only_relevant()});

	$('#date select').on('change',function(){
		dates_updates();
	});


	$('#gen_btn').on('click',function () {
		
		if(filters.date.from==null) {alert('Please select date first.'); return;}

		$(this).attr('disabled','disabled');
		var json=JSON.stringify(filters);
		$('.loading').show();

		$.ajax({
			url:"./general_ajax",
			data:{j:json},
			type:"post",
			success:function(data){

				data=JSON.parse(data,true);
				chart_type=data['chart'];
				data=data['data'];
				console.log(data);

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

				
				if(chart_type=='pie'){
					charts_data=prepare_report_chart2(labels,data);
					create_bar_chart(charts_data[0],charts_data[1]);
				}
				else{

					charts_data=prepare_report_chart(labels,data);
					create_line_chart(charts_data,labels);
				}

				$('#filter').hide();
				$('#graph').show();
				$('#report thead').html(hhtml);
				$('#report tbody').html(html);
				$('.loading').hide();
				$('#gen_btn').removeAttr('disabled');
			},
			error:function(msg){
				console.log(msg);
			}
		});

		
	});

	
	function hide_show_filters(){

		if($('#filter').is(":visible") ){
			$('#filter').hide('slow');
		}
		else{
			$('#filter').show('slow');	
		}
	}

</script>

@stop















@section('scripts')

	
@stop
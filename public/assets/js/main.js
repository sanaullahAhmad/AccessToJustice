//Global variables
var table;
var reports_data={};
var picker_opened=false;
var newchanges=false;
var newchanges_data={};
var new_changes_ex=[];

$(document).ready(function(){


	$('.select').selectBoxIt();
	$('.toolt').tooltip();
	
	hashchange();
});

$(window).on("hashchange",hashchange);

function bind_from_to_daterange(from,to){
	  
	   $.daterangepicker({
	      fromSelector: from,
	      toSelector: to,
	      readOnly:true //avoids manual user input
	   });
}

function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, 'g'), replace);
}

function bind_daterange(applied_callback){

	$('#daterange').on('click',function(e){

		 		//console.log(picker_opened);
		 		if(picker_opened==true){return;}
		 		picker_opened=true;
		 		update_picker_pos($(this).position().top,$(this).position().left+80);
		 		$('#picker').css('display','block');
		 		$('#picker').addClass('customdaterange');
		 		
				$('#picker').addClass('dropdown-menu');
				$('#picker').addClass('opensleft');
	});

	 $('#daterange_apply').on('click',applied_callback);


	$('#daterange_cancel').on('click',function(){

		 	reset_and_hide_picker();
	});

	$('.ranges li').on('click',function(){
		
		reset_picker();
		$(this).addClass('active');
		$('div[data-type="'+$(this).html()+'"]').show();
		var dif=$('#picker').width()-$('#daterange').width();		 	
		update_picker_pos($("#daterange").position().top,$("#daterange").position().left-(dif+45));
	});

}


function send_ajax(url,Data,callback){

	$.ajax({
		url:url,
		type:"get",
		data:Data,
		success:callback,
		error:function(msg){
			// console.log(msg);
		}
	})
}

function send_post_ajax(url,Data,callback){

	$.ajax({
		url:url,
		type:"post",
		data:Data,
		success:callback,
		error:function(msg){
			// console.log(msg);
		}
	})
}


function reset_and_hide_picker(){

	$('#picker').hide();
	picker_opened=false;
	reset_picker();
}

function reset_picker(){

$('.ranges li').removeClass('active'); 
update_picker_pos($('#daterange').position().top,$('#daterange').position().left+80);
$('.first').hide();	 	
}

function update_picker_pos(top,left){

	 	$('#picker').css('top',top+35);
	 	$('#picker').css('left',left);
}


function get_filtered_data_ids(){

	var nodes=table.$('tr', {"filter":"applied"});
	var ids=[];

	nodes.each(function(n,o){

		var tds=$(o).children('td');
		var td=tds.eq(tds.length-1);
		var id=$(td).attr('data-id');
		if(!id){ id=$(td).children('div').attr('data-id');  }
		ids.push(id);
	});

	return ids;
}

function bind_file_download_excel(){

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
}

function bind_file_download_pdf(){

	$('#btn-dwn-pdf').click(function(){
		
		$('#downloadmodal').modal();
		var ids=get_filtered_data_ids();
		$('#btn-dwn-pdf').prop('disabled', true);
		send_post_ajax($('#btn-dwn-pdf').attr('data-url'),{ids:ids.join()},function(data){
			
			data=JSON.parse(data); 
			$('#downloadmodal').modal('hide');
			 $('#btn-dwn-pdf').prop('disabled', false);
			$('#dwnldlink').attr('href','download'+'?filename='+data.path);
			$('#downloadreadymodal').modal();
		});
		
	});
}


function bind_file_download_charts_pdf(){
	
	$('#btn-rpt-pdf').click(function(){

		var id=$('#sum_table_select').val();
		
		var central=reports_data[parseInt(id)];
		var decentral=reports_data[parseInt(id)+1];

		central.charts=get_png(id);
		decentral.charts=get_png(parseInt(id)+1);

		var json=JSON.stringify({
				'centeral':central,
				'decentral':decentral
			});

		var url=$('#btn-rpt-pdf').attr('data-url');

		send_post_ajax($('#btn-rpt-pdf').attr('data-url'),{json:json},function(data){
			
			 
			$('#downloadmodal').modal('hide');
			$('#btn-dwn-pdf').prop('disabled', false);
			$('#dwnldlink').attr('href','download'+'?filename='+data);
			$('#downloadreadymodal').modal();
		});

		// var form = document.createElement("form");
	 //    form.setAttribute("method", "post");
	 //    form.setAttribute("action", url);
	 //    var input=document.createElement("input");
	 //    input.setAttribute("name","json");
	 //    input.setAttribute("value",json);
	 //    input.setAttribute("type","hidden");
	 //    form.appendChild(input);
	 //    document.getElementById("hidden-div").appendChild(form);
		
	 //    form.submit();
	});
}

function bind_print_view(){

	$('#btn-print-view').click(function() {
		
		if($('#record-table').is(":visible")){
			print_view('#record-table');
		}
		else{
			print_view('#record-table');
		}
		
		return false;
	});

}

function print_view(selector){

	$(selector).printArea();
}

function bind_file_upload_popup(){

	$('#upload_excel').on('click',function(){

		$('#upload_modal').modal('show');
	});
}

function bind_any_file_upload_popup(){

	$('#upload_file').on('click',function(){

		$('#upload_modal').modal('show');
	});
}

function delete_popup(form){

		bootbox.confirm("Are you sure?", function(result) {

			if(result){
				form.submit();
			}
		}); 
		return false;
}

function block_popup(button){

		var id=button.id;
		var blocked=$("#"+id).attr('blocked');
		var route=$("#"+id).attr('route');

	

		var msg=(blocked==1)?'Are you sure you want to unblock this user?':'Are you sure you want to block this user?';

		bootbox.confirm(msg, function(result) {
			if(result){
				
				window.location="block_unblock/"+id.replace('block','')+"/"+route;
			}
		}); 
		
		return false;
		
}

	/*

		reports functions

	*/



function build_datatable(options){


		var exceptionList=options['reports_exception'];
	//alert('build_datatable');
		var centerForDecent=remove_duplicates(options['centers']);
		var summaryTables={};
		var CenterColumn=options['center_column'];
		var charts_data={};
		var regex = /(<([^>]+)>)/ig;
		
		$("#record-table tfoot th").each( function ( i,o ){

			var headingId,
			centerHeadingId=$('#record-table thead th').eq(CenterColumn).html().replace(/\s/g, "_");


			if($("#record-table tfoot th").size()-1==i){return;}

			headingId=$('#record-table thead th').eq(i).html();
			//alert(headingId);
			$('#record-table tfoot th').eq(i).html('');

			if(exceptionList.indexOf(headingId.trim(' '))<0 || headingId.trim(' ')=='Center')
			{
				//alert('build_datatable');
				headingId=headingId.trim(' ').replace(/\s/g, "_").replace('(','').replace(')','').replace(',','');
				
				var thead_th=$('#after-head td').eq(i);
				var header=$('#record-table thead th').eq(i).html();
				$('#'+headingId.trim(' ').replace('/','')).remove();

				var top_select = $('<select  style="max-width:60px;" id="'+headingId.trim(' ').replace('/','')+'"><option value=""></option></select>')
				.appendTo( $(thead_th))
				.on( 'change', function () {
					var vnamee = $(this).val() || '';
					var val = vnamee.trim(' ');
					//var val = $(this).val().trim(' ');
					table.column( i )
					.search( val ? '^'+$(this).val()+'$' : val, true, true)
					.draw();
				});


				var select = $('<select  style="max-width:60px;" id="'+headingId.trim(' ').replace('/','')+'"><option value=""></option></select>')
				.appendTo( $(this).empty() )
				.on( 'change', function () {
					var vnamee2 = $(this).val() || '';
					var val = vnamee2.trim(' ');
					//var val = $(this).val().trim(' ');
					table.column( i )
					.search( val ? '^'+$(this).val()+'$' : val )//, true, true
					.draw();
				});
			
				var summaryCoulmns= {}; 
				var summaryTotal=0;
				table.column()
				table.column( i ).data().each(function(i){i=i.replace(regex, "").trim(' '); summaryCoulmns[i] = (summaryCoulmns[i]||0)+1;  summaryTotal++; });
				summaryCoulmns['Total']=summaryTotal;
				summaryTables[header+" Summary"]=summaryCoulmns;

				var summaryCoulmnsDecent={};
				var summaryCoulmnsDecentTotal={};
				var availableCenters=[];
				table.column( CenterColumn ).data().each(function(i){i=i.replace(regex, "").trim(' '); availableCenters.push(i); });
				var availableCentersArr=table.column( CenterColumn ).data();
				
				var to=0;
				table.column(i).data().each(function(k,idx){

					k=k.replace(regex, "").trim(' ');
					var c=availableCentersArr[idx];
					
					c=c.replace(regex, "").trim(' ');
					 
					if(typeof summaryCoulmnsDecent[k]=='undefined'){summaryCoulmnsDecent[k]={};}
					if(typeof summaryCoulmnsDecent[k][c]=='undefined'){
							
						summaryCoulmnsDecent[k][c]=0;summaryCoulmnsDecentTotal[c]=0;
					}

					if(availableCenters.indexOf(c)>-1){
					
						summaryCoulmnsDecent[k][c]=(summaryCoulmnsDecent[k][c]||0)+1; 
					}

					to++;

				});

			 
				//summaryCoulmnsDecentTotal[c]=(summaryCoulmnsDecentTotal[c]||0)+1;				

				for(var field in summaryCoulmnsDecent){
	 				
	 				centerForDecent.forEach(function(j){

	 					if(typeof summaryCoulmnsDecent[field][j] == 'undefined'){
	 						summaryCoulmnsDecent[field][j]=0;
	 						summaryCoulmnsDecentTotal[j]=0;
	 					}
					});	
	 			}


				for(var field in summaryCoulmnsDecent){

	 				centerForDecent.forEach(function(j){
 						summaryCoulmnsDecentTotal[j]+=summaryCoulmnsDecent[field][j];
					});	
	 			}	 			
 

				summaryCoulmnsDecent['Total']=summaryCoulmnsDecentTotal;
				summaryTables[header+" Decent"]=summaryCoulmnsDecent;
				var table_key=header.replace(' ','_').trim(' ');
				
				charts_data[table_key]={};
				charts_data[table_key].decent=summaryCoulmnsDecentTotal;
				charts_data[table_key].summary=summaryCoulmns;
				
				column_counts={};



				table.column( i ).data().sort().each( function ( d, j ) {
					d=d.replace(regex, "").trim(' ');
					 
					column_counts[d]=(column_counts[d]||0)+1;
				});

				if(options['fof']&&( i==options['fofs'][0]||i==options['fofs'][1])){
					
					var fof=options['fof']; 
					var cold=table.column( fof ).data();
					// console.log(cold);
					newchanges=true;
					table.column( i ).data().each( function ( d, j ) {
						// console.log(table.rows);
						e=cold[j];

						d=d.replace(regex, "").trim(' ');
						e=e.replace(regex, "").trim(' ');
						if(e!='-'){
							if(d=='-'||d==''){d=headingId+"(-)"}
							if(!newchanges_data[headingId]){newchanges_data[headingId]={};}
							newchanges_data[headingId][e+'::'+d]=(newchanges_data[headingId][e+'::'+d]||0)+1;
						}
							
					});
					new_changes_ex=options['fofs'];
				}
				
				console.log(newchanges_data,new_changes_ex);
				
				for(var d in column_counts) {
									
					 
					 
					top_select.append( '<option value="'+d+'">'+d+'('+column_counts[d]+')</option>');
					select.append( '<option value="'+d+'">'+d+'('+column_counts[d]+')</option>');
				}
			}	
		});
	 
	// console.log(charts_data);
	generateSummaryTables(summaryTables,centerForDecent,charts_data);
	newchanges=false;
	newchanges_data={};
	$('#summaryTablesContainer').prepend('<div><select id="sum_table_select" class="select"><option>Select</option></select><button id="sum_table_btn" class="btn btn-primary">Generate</button></div>');

	bind_reports_gen_btn();

	var arr = Array();
	var temp;
	var num = 0;
	arr = $('#summaryTablesContainer div[id^=sum_]').each(function(d, j){
		num++;
		var at = $(j).attr('table'); 

		if(temp!=at)
		{
			
			$('#sum_table_select').append('<option value="'+num+'">'+at.replace('_',' ')+'</option>');
			var t = at.trim();
			
		    // charts_formatted_data=chartFormat(charts_data[t].decent);
		   
		}

		temp = at;
	});
}


function bind_reports_gen_btn(){

	$('#summaryInnerContainer').children('div').hide();
	$('#sum_table_btn').on('click',function(){

		var val=$('#sum_table_select').val();
		$('#summaryInnerContainer').children('div').hide();
		$('div[id=sum_'+val+']').fadeIn('slow');
		$('div[id=sum_'+(parseInt(val)+1)+']').fadeIn('slow');
	});

}

function remove_duplicates(arr){

	var tmp=[];

	for(var i in arr){
		if(tmp.indexOf(arr[i])<0){tmp.push(arr[i]);}
	}
	return tmp;
}

function hashchange() {
	
	$(document).ready(function(){


		var hash = window.location.hash;
		hash=hash.replace("#","");
		if(hash!=""){

			var selects=hash.split("|");
			for(var i in selects){
				 
				selects[i]=selects[i].replace('(',"").replace(')',"").replace(',',"");
				var eventi=selects[i].split("$");
				
				

				$('select#'+eventi[0].trim(' ')).find('option[value="' + eventi[1].trim(' ')+ '"]').attr('selected','selected');
				if(eventi[1].trim(' ')=="Total"){eventi[1].trim(' ')="";}
				$('select#'+eventi[0].trim(' ')).val(eventi[1].trim(' ')).change();
			}

			$('#summaryTablesContainer').hide();
			$('#record-table_wrapper').fadeIn('fast');
			$(this).prop('disabled', true);
			$('#reports-btn').prop('disabled', false);
			$('.dwn-btns').eq(1).hide();
			$('.dwn-btns').eq(0).show();
		}	
	});
	
}

function generateSummaryTables(summaryTables,centerForDecent,charts_data){

	



	var tableHtmlHeader='<thead style="background-color: #242B35;color: white;"><tr><th>Name</th><th>Count</th></tr></thead><tbody>';
	var tableHtmlFooter='</tbody></table>';

	var counter = 0;
	var counter2 = 0;
	
	var charts_formatted_data;
	for (var table in summaryTables){
		counter++;

		var tableDeHtml='';
		var tableHtml='';  

		if(table.indexOf("Decent")<0){
			
			var nch='';
			if(new_changes_ex.length>0&&new_changes_ex[2]==counter2 || new_changes_ex[3]==counter2){ nch='<th>First Time</th><th>Follow-up</th>';}
			tableHtml='<table style="width:100%" id="report"><thead><tr><th>Name</th>'+nch+'<th>Count</th></tr></thead>' 
			var tabl= summaryTables[table];

			for(var column in tabl){

				var hash=table.replace(" Summary","").trim(' ').replace(/\s/g, "_").replace(')','').replace('(','').replace('/','').replace(',','')+'$'+column;
				if(tabl[column]==0){hash="";}
				console.log(new_changes_ex[0]==counter2 , new_changes_ex[1]==counter2);
				
				
				if(new_changes_ex.length>0&&new_changes_ex[2]==counter2 || new_changes_ex[3]==counter2){
								 
					var dtt=column;
					if(dtt=='-'||dtt==''){dtt=table.replace('Summary','').trim(' ')+"(-)"}
					 console.log("dtt"+dtt);
					var ft=newchanges_data[table.replace('Summary','').trim(' ').replace(/\s/g, "_").replace('(','').replace(')','').replace(',','')]["First Time::"+dtt]|| '';
					var fo=newchanges_data[table.replace('Summary','').trim(' ').replace(/\s/g, "_").replace('(','').replace(')','').replace(',','')]["Follow-up::"+dtt]|| '';
					
					tableHtml+='<tr><div id="'+column.replace("","")+'" style="display:none;">'+column+'</div><td style="border: 1px solid #969696;">'+column+'</td><td style="border: 1px solid #969696;">'+ft+'</td><td style="border: 1px solid #969696;">'+fo+'</td><td style="border: 1px solid #969696;">'
					+'<a class="count" href="#'+hash+'" style="cursor:pointer;">'+tabl[column]+'</a></td></tr>'

				}else{
					tableHtml+='<tr><div id="'+column.replace("","")+'" style="display:none;">'+column+'</div><td style="border: 1px solid #969696;">'+column+'</td><td style="border: 1px solid #969696;">'
					+'<a class="count" href="#'+hash+'" style="cursor:pointer;">'+tabl[column]+'</a></td></tr>'

				}
 
			}

			tableHtml+=tableHtmlFooter+"<br>";
			var chart_key=table.replace(" Summary","").replace(" ","_").trim('');
			charts_formatted_data=chartFormat(charts_data[chart_key].summary);
			charts_formatted_data.pop();
			counter2++;  
		
		}else{

			
			var centerTh='';
			var tablDe=summaryTables[table];
			var c=tablDe[Object.keys(tablDe).pop()];
			
			c=$.map(c, function(value, index) {
			    return [index];
			});
			c=c.sort();
			if(c.length>0 && c[0].trim(' ')==""){
				c.shift();
			}

			for(var i in c.sort()){

				centerTh+='<th>'+c[i]+'</th>';
			}

			centerTh+='<th>Total</th>';

			tableDeHtml='<table id="report"><thead><tr><th>Name</th>'+centerTh+'</tr></thead>'
			var tablDe=summaryTables[table];


			for(var column in tablDe){

				var right_total=0;

				tableDeHtml+='<tr><div id="'+column.replace("","")+'" style="display:none;">'+column+'</div><td style="border: 1px solid #969696;">'+column+'</td>';

				for(var Center in c){

					var hash=table.replace(" Decent","").trim(' ').replace(/\s/g, "_").replace(')','').replace('(','').replace('/','').replace(',','')+'$'+column+'|Center$'+c[Center];
					if(tablDe[column][c[Center]]==0){hash="";}
					if(column.trim(' ')=='Total'){

						right_total+=parseInt(tablDe[column][c[Center]]);
						tableDeHtml+='<td style="border: 1px solid #969696;">'
						+'<a class="count" href="#'+hash+'" style="cursor:pointer;"><b>'+tablDe[column][c[Center]]+'</b></a></td>'  
					}
					else{

						right_total+=parseInt(tablDe[column][c[Center]]);
						tableDeHtml+='<td style="border: 1px solid #969696;">'
						+'<a class="count" href="#'+hash+'" style="cursor:pointer;">'+tablDe[column][c[Center]]+'</a></td>'  	
					}
					
				}

						hash=table.replace(" Decent","").trim(' ').replace(/\s/g, "_").replace(')','').replace('(','').replace('/','').replace(',','')+'$'+column;
						tableDeHtml+='<td style="border: 1px solid #969696;">'
						+'<a class="count" href="#'+hash+'" style="cursor:pointer;"><b>'+right_total+'</b></a></td>'  	
				tableDeHtml+='</tr>';
			}

			tableDeHtml+=tableHtmlFooter;
			var chart_key=table.replace(" Decent","").replace(" ","_").trim('');
			charts_formatted_data=chartFormat(charts_data[chart_key].decent);
		}

		var t=table.replace('Summary','').replace('Decent','').replace(' ','_').trim();
		
		var charts='<div style="width:100%" id="graph" class="graph"><div  id="pie-chart-'+counter+'" class="placeholder"></div></div>';
		// console.log('appending');
		$('#summaryInnerContainer').append('<div id="sum_'+counter+'" style="" table="'+t+
							'">'+charts+tableHtml+tableDeHtml+'</div>');
		
		create_pie_chart(counter,charts_formatted_data);

		reports_data[counter]={
			heading:table.replace('Summary','').replace('Decent',''),
			charts:null,
			data:charts_formatted_data,
			html:tableHtml+tableDeHtml
		}
	}
}

function make_charts(id,data)
{
	// console.log(id);
	var pie = new Chart(document.getElementById("pie-chart-"+id).getContext("2d")).Pie(data,{animation: false});
	$('#legend-chart-pie'+id).append(pie.generateLegend());
	 
	return {'pie':pie.toBase64Image()};
}

function chartFormat(obj){

  var formated=[];

  $.each(obj,function(k,v){
   	formated.push([k,parseInt(v)]);
  });

  return formated;
}

	function create_pie_chart(counter,data){
		
		$('#pie-chart-'+counter).highcharts({
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
                        //style: { fontFamily: '\'Lato\', sans-serif', lineHeight: '18px', fontSize: '14px' }
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
                name: 'Chart',
                data: data
            }],
		    exporting: {
		        enabled: true,
		        sourceWidth: 900
		    }
        });


		
	}

	function get_png(counter){

		 
		var svg = document.getElementById('pie-chart-'+counter).children[0].innerHTML;
	    
		canvg(document.getElementById('canvas'),svg);
		    
		var img = canvas.toDataURL("image/png"); 
		    
		img = 'data:image/png;base64,'+img.replace('data:image/png;base64,', '');

		return {'pie':img};

	}

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
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
		
		@if(!Entrust::hasRole('Normal_User'))
		
		<a class="btn btn-default" href="{{ 	URL::route('meeting.index') 	}}">Go Back</a>
		
		@endif
		</div>

	</div>
	
@stop

@section('content')
<style type="text/css">
	.actions{cursor: pointer;}

</style>


	<div class="clear"></div>
	
	<form>

		<div class="row">
		<label class="control-lable col-sm-4">District: </label>
		<div class="col-sm-3">
			<select class="select" id="district">
				<option value="">Select</option>  
				@foreach ($data['districts'] as $key=>$value)
				    <option value="{{{$key}}}">{{{$value}}}</option>
				@endforeach
			</select>
		</div>
		</div>

<br>		 
	  <div class="row">
	    <label class="control-lable col-sm-4">Dates: </label>
	    <div class="col-sm-3">
	    	<input id="date" type="text" class="form-control"  placeholder="Enter Dates">
	    </div>
	  </div>
<br>
	  <div class="row">
	    <label class="control-lable col-sm-4">Quarter: </label>
	    <div class="col-sm-3">
	    	<input id="quater" type="text" class="form-control"  placeholder="">
	    </div>
	  </div>
<br>
	  <div class="row">
	    <label class="control-lable col-sm-4">Right Based Organizations </label>
	    <div class="col-sm-3 ed">
    	<ul id="rb" class="list-group"></ul> 
	    </div>
	    <div class="col-sm-3">
	    <button data-id="rb" class="addmore btn btn-primary">Add More</button>
	    </div>
	  </div>
<br>
	  <div class="row">
	    <label class="control-lable col-sm-4">Social Actvists </label>
	    <div class="col-sm-3 ed">
    	<ul id="sa" class="list-group"></ul> 
	    </div>
	    <div class="col-sm-3">
	    <button data-id="sa" class="addmore btn btn-primary">Add More</button>
	    </div>
	  </div>
<br>
	  <div class="row">
	    <label class="control-lable col-sm-4">Government Departments</label>
	    <div class="col-sm-3 ed">
    	<ul id="gd" class="list-group"></ul> 
	    </div>
	    <div class="col-sm-3">
	    <button data-id="gd" class="addmore btn btn-primary">Add More</button>
	    </div>
	  </div>
<br>
	  	<div class="row">
	    <label class="control-lable col-sm-4">Political Personalities</label>
	    <div class="col-sm-3 ed">
    	<ul id="pp" class="list-group"></ul> 
	    </div>
	    <div class="col-sm-3">
	    <button data-id="pp" class="addmore btn btn-primary">Add More</button>
	    </div>
	  </div>
<br>
	  	<div class="row">
	    <label class="control-lable col-sm-4">District Bar</label>
	    <div class="col-sm-3 ed">
    	<ul id="db" class="list-group"></ul> 
	    </div>
	    <div class="col-sm-3">
	    <button data-id="db" class="addmore btn btn-primary">Add More</button>
	    </div>
	  </div>
	  <div class="row">
	  	<div class="col-md-3 col-md-offset-5"><button id="submit" type="submit" class="btn btn-primary">Submit</button></div>
	  </div>
	  
	</form>
	
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add/Edit Items</h4>
      </div>
      <div class="modal-body">
        

      <div class="row">
	    <label class="control-lable col-sm-4">Name: </label>
	    <div class="col-sm-5">
	    	<input id="name_in" type="text" class="form-control"  placeholder="Enter Name">
	    </div>
	  </div>
	  <br>
	  <div class="row">
	    <label class="control-lable col-sm-4">Persons: </label>
	    <div class="col-sm-6">
	    	<textarea id="persons_in" class="form-control"></textarea>
	    </div>
	  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="save" type="button" class="btn btn-primary">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" id="current_selector" value="">
@stop

@section('scripts')

<script type="text/javascript">

function bind_lists(){
	$('.list-group-item').popover({ 
	trigger:"click",
	title:"Action",
	content:"<span data-type='edit' onclick='doAction(this)' class='actions glyphicon glyphicon-edit'></span>&nbsp;&nbsp;<span onclick='doAction(this)' data-type='del' class='actions glyphicon glyphicon-trash'></span>",
	html:true
	});

}
bind_lists();

function bind_list_click(){
	$('.list-group-item').on('click',function(){

	var id=$(this).parent().attr('id');
	console.log(id,$('#'+id).children('li'));
	var index=$('#'+id).children('li').index($(this));
	$('#current_selector').val(id+"-"+index);
});
}

bind_list_click();

$('.addmore').click(function(evt){ clear();$('#current_selector').val($(this).attr('data-id'));evt.preventDefault(); $('.list-group-item').popover('hide');$('#myModal').modal('show')});

function clear(){
	$('#name_in').val('');
	$('#persons_in').val('');
}

function doAction(ob){
 
	var type=$(ob).attr('data-type');

	var sel_arr=$('#current_selector').val().split("-");
	var sel="ul#"+sel_arr[0]+" li";

	if(type=='edit'){
		clear();
		var t=$(sel).eq(sel_arr[1]).children('span').text();
		$('#persons_in').val(t);
		$(sel).eq(sel_arr[1]).children('span').remove();
		
		$('#name_in').val($(sel).eq(sel_arr[1]).text());
		$(sel).eq(sel_arr[1]).append('<span style="display:none;">'+t+'</span>');

		$('.list-group-item').popover('hide');
		$('#myModal').modal('show');
	}else{

		$(sel).eq(sel_arr[1]).remove();
	}
}


$('#save').on('click',function(){

	var selector=$('#current_selector').val();
	var sel_arr=selector.split('-');
	var sel="ul#"+sel_arr[0]+" li";

	if(selector.indexOf('-')==-1){

		$("ul#"+sel_arr[0]).append('<li class="list-group-item">'+$('#name_in').val()+'<span style="display:none;">'+$('#persons_in').val()+'</span></li>');
	}
	else{
		
		$(sel).eq(sel_arr[1]).text($('#name_in').val());
		$(sel).eq(sel_arr[1]).append('<span style="display:none;">'+$('#persons_in').val()+'</span>');
	}

	$('#myModal').modal('hide');
	bind_lists();
	bind_list_click();
});

$('#submit').on('click',function(evt){
	
	evt.preventDefault();
	district=$('#district').val();
	date=$('#date').val();
	quater=$('#quater').val();
	org={
		rb:[],
		gd:[],
		pp:[],
		db:[],
		sa:[]
	}

	$('#rb').children('li').each(function(key,value){
		var t=$(value).children('span').text().split(','); 
		$(value).children('span').remove();
		org.rb.push({name:$(value).text(),persons:t});
	});

	$('#gd li').each(function(key,value){
		var t=$(value).children('span').text().split(','); 
		$(value).children('span').remove();
		org.gd.push({name:$(value).text(),persons:t});
	});

	$('#pp li').each(function(key,value){
		var t=$(value).children('span').text().split(','); 
		$(value).children('span').remove();
		org.pp.push({name:$(value).text(),persons:t});
	});

	$('#db li').each(function(key,value){
		var t=$(value).children('span').text().split(','); 
		$(value).children('span').remove();
		org.db.push({name:$(value).text(),persons:t});
	});

	$('#sa li').each(function(key,value){
		var t=$(value).children('span').text().split(','); 
		$(value).children('span').remove();
		org.sa.push({name:$(value).text(),persons:t});
	});


	$.ajax({
		url:"./",
		method:"post",
		data:{district:district,date:date,quater:quater,org:JSON.stringify(org)},
		success:function(data){

		 window.location="./";
		}
	});

});

</script>
	
@stop
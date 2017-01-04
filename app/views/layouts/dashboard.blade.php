@extends('layouts.default')

@section('content')
<style type="text/css">

#court_cases_table td{
  padding: 5px 10px;
}
</style>


    <div class="alert alert-info" style="background-color:#FDFEFF;font-size:18px;">WELCOME TO A2J DASHBOARD</div>

    <div class="row ">

     <div style="margin-top:-20px;width:61%px;" class="col-md-7 project_info">
      <h3>Access To Justice <small>Project Info</small></h3>
      <img height="90px" align="left" valign="top" alt="info" src="{{asset('assets/images/info.png')}}">
      <p style="text-align: justify;">The Access to Justice for Vulnerable Populations in Pakistan is a three year initiative to improve access to justice and human rights through the provision of efficient, cost effective legal assistance and protection for vulnerable populations in Pakistan. The project has been designed to target 13 districts, across all four provinces. These districts are Lahore, Faisalabad, Nankanasahib, Muzaffargarh, Khanewal, Sialkot, Swat, Karachi, Jacobabad, Multan, Sahiwal, Hyderabad, and Quetta, which also represent urban, rural, and ethnically and religiously diverse populations.</p>
    </div>

    <div class="col-md-7">


      <table border="0" class="courtc_table" style="width:566px;border-spacing:0px;margin-left:30px;border:1px solid #6C85A9;" id="court_cases_table">
       <thead>
        <tr>
         <th colspan="2" style="text-align:center;font-size:16px;font-famiy:-webkit-pictograph;">Access To Justice Project Progress (DLAC) <br> 
         		(<span style="font-size:12px;font-weight:normal;">{{ date('F d, Y',strtotime(ProjectDate::find(1)->start))}}  -  {{ date('F d, Y',strtotime(ProjectDate::find(1)->end))}}</span>)</th>
       </tr>
     </thead>

     <?php
        // var_dump(Entrust::hasRole('Admin'));exit();
        $index='';
        if(Entrust::hasRole('Admin') || Entrust::hasRole('Normal_User')) {$index='/pre_index';} 
      ?>
     <tbody>
      <tr>
       <td>Total Walkin Clients</td>
       <td style="text-align:center;width:70px;"><a href="{{URL::to('walkin'.$index)}}"><b>
        {{$data['total_walkins']}}</b></a></td>
     </tr>
     <tr>
       <td>Total Incoming Calls on Helpline</td>
       <td style="text-align:center;"><a href="{{URL::to('incoming'.$index)}}"><b>{{$data['total_incomings']}}</b></a></td>
     </tr>
     <tr>
       <td>Total Outgoing Calls to Beneficiaries</td>
       <td style="text-align:center;"><a href="{{URL::to('outgoing'.$index)}}"><b>{{$data['total_outgoings']}}</b></a></td>
     </tr>
     <tr>
       <td>Total Counseling & Legal Advice Provided</td>
       <td style="text-align:center;"><a href="{{URL::to('legalaid'.$index)}}"><b>{{$data['total_legalaids']}}</b></a></td>
     </tr>
     <tr>
       <td>Total Legal Assistance</td>
       <td style="text-align:center;"><a href="{{URL::to('legalassistance'.$index)}}"><b>{{$data['total_assistances']}}</b></a></td>
     </tr>

     <tr>
       <td>Total Court Cases Support Provided</td>
       <td style="text-align:center;"><a href="{{URL::to('cases'.$index)}}"><b>{{$data['total_cases']}}</b></a></td>
     </tr>

     <tr>
      <td>Psychosocial Support Provided</td>
      @if(Entrust::hasRole('Center_User'))
       <td style="text-align:center;"><a href="{{URL::to('support_pre_index')}}"><b>{{$data['total_PSYsupport']}}</b></a></td>
       @else
        <td style="text-align:center;"><a href="{{URL::to('centers_support_pre_index')}}"><b>{{$data['total_PSYsupport']}}</b></a></td>
       @endif
      
    </tr>

    <tr>
     <td>Total Referrals to other Justice Providers</td>
     @if(Entrust::hasRole('Center_User'))
     <td style="text-align:center;"><a href="{{URL::to('refer_pre_index')}}"><b>{{$data['total_referals']}}</b></a></td>
     @else
      <td style="text-align:center;"><a href="{{URL::to('centers_refer_pre_index')}}"><b>{{$data['total_referals']}}</b></a></td>
     @endif
   </tr>



 </tbody>
</table>
</div>
<div style="text-align:right;display:inline;  ">

 <a href="{{asset('assets/images/Map.jpg')}}" class="zoom"><img src="{{asset('assets/images/Map.jpg')}}" alt="Access To Justice" id="atj" height="450px"  style="cursor:pointer;background: rgba(255,255,255, 0.3);
  border-radius: 10px 10px 10px 10px;
  box-shadow: 0 1px 1px #AAAAAA;
  border-top: 0px solid #DDD;margin-bottom:-25px;width:400px;margin-left:45px;margin-top:10px;"  /></a>
</div>




</div>


<div class="modal fade" id="map_big" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Project Map</h4>
      </div>
      <div style="max-height:600px;overflow:scroll;" class="modal-body">
        <img style="max-width:900px;" src="{{asset('assets/images/Map.jpg')}}">

      </div>
    </div>
  </div>
</div>

<!-- <div id="map_big"  class="modalbg" tabindex="-1" role="dialog">
  <div  class="dialog">
    <a href="#close" title="Close" class="close">X</a>
    <img style="max-width:900px;" src="{{asset('assets/images/Map.jpg')}}">

  </div>
</div> -->


@stop

@section('scripts')

  <script type="text/javascript">
  
  jQuery(function($){
    
    $('a.zoom').easyZoom();

  });

  </script>

@stop
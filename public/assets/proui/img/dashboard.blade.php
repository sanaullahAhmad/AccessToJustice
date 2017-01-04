@extends('layouts.default')

@section('content')
<style type="text/css">

#court_cases_table td{
  padding: 5px 10px;
}
</style>


<div class="content-header content-header-media">
<div class="header-section">
<div class="row">
<div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
<h1>Welcome <strong>{{Confide::user()->username}}</strong><br><small> to LEP Dashboard!</small></h1>
</div>
<div class="col-md-8 col-lg-6">
<div class="row text-center">
<div class="col-xs-4 col-sm-3">
<h2 class="animation-hatch">
<strong>{{$data['total_walkins']}}</strong><br>
<small><i class="fa fa-users"></i> Clients</small>
</h2>
</div>
<div class="col-xs-4 col-sm-3">
<h2 class="animation-hatch">
<strong>{{$data['total_cases']}}</strong><br>
<small><i class="fa fa-balance-scale"></i> Cases</small>
</h2>
</div>
<div class="col-xs-4 col-sm-3">
<h2 class="animation-hatch">
<strong>{{$data['total_clinics']}}</strong><br>
<small><i class="fa fa-plus"></i> Clinics</small>
</h2>
</div>
<div class="col-sm-3 hidden-xs">
<h2 class="animation-hatch">
<strong>{{$data['total_paralegals']}}</strong><br>
<small><i class="fa fa-legal"></i> Paralegals</small>
</h2>
</div>
</div>
</div>
</div>
</div>

<img class="" alt="header image" src="{{asset('assets/proui/img/clsf_db_bg.jpg')}}">
</div>


    <!-- <div class="alert alert-info" style="background-color:#FDFEFF;font-size:18px;">WELCOME TO LEP DASHBOARD</div> -->

    <div class="row ">

      <div class="col-md-6 col-sm-6">
        <div class="widget">
          <div class="widget-simple animation-pullDown">
            <a class="widget-icon pull-left themed-background-amethyst  animation-fadeIn" href="#">
              <i class="fa fa-file-text"></i>
            </a>
            <h3 class="widget-content text-left animation-pullDown">
              Project <strong>Statistics</strong><br>
              <small>Legal Empowerment of the Poor </small>
            </h3>
            <br><br>
            <table border="0" class="table table-striped table-vcenter" style="" id="court_cases_table">
<!--        <thead>
        <tr>
         <th colspan="2" style="text-align:center;font-size:16px;font-famiy:-webkit-pictograph;">Legal Empowerment of the Poor (LEP)</th>
       </tr>
     </thead> -->

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
       <td>Total Counseling & Legal Advice Provided</td>
       <td style="text-align:center;"><a href="{{URL::to('legalaid'.$index)}}"><b>{{$data['total_legalaids']}}</b></a></td>
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
   <tr>
     <td>Total Legal Assistance Provided</td>
     <td style="text-align:center;"><a href="{{URL::to('cases'.$index)}}"><b>{{$data['total_assistances']}}</b></a></td>
   </tr>

   <tr>
     <td>Total Court Cases Support Provided</td>
     <td style="text-align:center;"><a href="{{URL::to('cases'.$index)}}"><b>{{$data['total_cases']}}</b></a></td>
   </tr>


   <tr>
     <td>Legal Aid Clinics</td>
     <td style="text-align:center;"><a href="{{URL::to('clinic'.$index)}}"><b>{{$data['total_clinics']}}</b></a></td>
   </tr>

   <tr>
     <td>Community Paralegals</td>
     <td style="text-align:center;"><a href="{{URL::to('paralegal'.$index)}}"><b>{{$data['total_paralegals']}}</b></a></td>
   </tr>

 </tbody>
</table>

</div>
</div>

</div>


<div class="col-sm-6 col-lg-6">
        <div class="widget">
          <div class="widget-simple">
            <a class="widget-icon pull-left themed-background  animation-fadeIn" href="#">
              <i class="fa fa-info"></i>
            </a>
            <h3 class="widget-content text-left animation-pullDown">
              Project <strong>Info</strong><br>
              <small>Legal Empowerment of the Poor </small>
            </h3>
          </div>
        </div>


        <div class="widget">
          <div class="widget-simple animation-pullDown">
            <p>The Legal Empowerment of the Poor (LEP) Project is an initiative under Enhanced Democratic Accountability and Civic Engagement (EDACE) Programme to improve access to justice for poor, disempowered and marginalized segments in southern Punjab and Sindh. The project has been designed to target 13 districts in Punjab and Sindh provinces. These districts are Sukkhur, Ghotki, Larkana, Jacobababd, Kashmore, Mirpur Khas, Umerkot, Tharparker, Karachi, Hyderabad, Multan, Muzafargrah and Rajanpur.</p>
          </div>
        </div>
      </div>



</div>
<!-- 
map 

<div class="row">
<div style="text-align:right;display:inline;  ">

 <a href="{{asset('assets/images/Map.jpg')}}" class="zoom"><img src="{{asset('assets/images/Map.jpg')}}" alt="Access To Justice" id="atj" height="450px"  style="cursor:pointer;background: rgba(255,255,255, 0.3);
  border-radius: 10px 10px 10px 10px;
  box-shadow: 0 1px 1px #AAAAAA;
  border-top: 0px solid #DDD;margin-bottom:-25px;width:400px;margin-left:45px;margin-top:10px;"  /></a>
</div>




</div> -->


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
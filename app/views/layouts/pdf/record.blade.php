<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<style type="text/css">
.col-lg-6{
  position: relative;
  min-height: 1px;float: left;
  padding-right: 10px;
  padding-left: 10px;width:48%;
}
.row:before,
.row:after,.container-fluid:before,
.container-fluid:after{display: table;
content: " ";clear: both;}
.row {
margin-right: -10px;
margin-left: -10px;
}
.container-fluid {
padding-right: 10px;
padding-left: 10px;
margin-right: auto;
margin-left: auto;
}

thead{
    background-color: #242B35;
    color: white;
}

tfoot{
    background-color: #242B35;
}

li{
    display: inline-block !important;
    margin-right: 5px;
}
.doughnut-legend li{
    display: inline-block !important;
    margin-right: 5px;
}
.pie-legend li span {
    width: 1em;
    height: 1em;
    display: inline-block;
    margin-right: 5px;
}

.pie-legend {
    list-style: none;    
}
.doughnut-legend li span {
    width: 1em;
    height: 1em;
    display: inline-block;
    margin-right: 5px;
}

.doughnut-legend{
    list-style: none;    
}
a{
  text-decoration: none;
  color:black;
}

@page {
  margin: 0.5cm;
}
body {
  font-family: sans-serif;
  margin: 0.5cm 0;
  text-align: justify;
}
#header,
#footer {
  position: fixed;
  left: 0;
  right: 0;
  color: #aaa;
  font-size: 0.9em;
}
#header {
  top: 0;
  border-bottom: 0.1pt solid #aaa;
}
#footer {
  bottom: 0;
  border-top: 0.1pt solid #aaa;
}
#header table,
#footer table {
  width: 100%;
  border-collapse: collapse;
  border: none;
}
#header td,
#footer td {
  padding: 0;
  width: 50%;
}
.page-number {
  text-align: center;
}
.page-number:before {
  content: "Page " counter(page);
}
hr {
  page-break-after: always;
  border: 0;
}
body{
  margin: 20px;
}
</style>
</head>
<body>
<div id="header">
  <table>
    <tr>
      <td><img width="55px" height="55px" src="{{asset('assets/images/pdf_logo.png')}}"></td>
      <td style="text-align: right;color:black;font-weight:700;">{{$data['heading']}}</td>
    </tr>
  </table>
</div>

<div id="footer">
  <div class="page-number"></div>
</div>


<div style="clear:both;margin-bottom:5px;"><br><br></div>
<div style="display: block;page-break-after: always;font-size: 10px;" table="Priority_Group">
  <table>
    <thead>
      <tr>
      <?php $date_col=0;$i=0; ?>
        @foreach( $data['headings'] as $value )   
            <th>{{ $value }}</th>
            <?php if($value=='date'){$date_col=$i;} ?>
            <?php $i++; ?>
        @endforeach

      </tr>
    </thead>
    <tbody>
    <?php $j=0; ?>
        @foreach( $data['records'] as $record )   
            
          <tr>
             <?php $i=0; ?>
            @foreach( $record as $value )   
              @if($i==0)
              <td>{{++$j}}</td>
              @elseif($date_col==$i)
              <td style="min-width:80px;">{{date('m-d-y',$value)}}</td>
              @else
              <td>{{$value}}</td>
              @endif
             <?php $i++; ?>
            @endforeach
          </tr>
        @endforeach
    </tbody>
  </table>
</div>
</body>
</html>
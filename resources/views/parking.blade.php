<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>Dashboard | Airport Control Tower API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('head')
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        
        @include('admin_header')
        
        <div class="app-main">
        @include('side_menu')
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                <div class="tabs-animation">
                    <div class="mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        </div>
 
    </div>

<div class="row m-3">

<div class="col-md-12 prkngHdrWrap">
   <h4>Parking Overview</h4>
  </div>

    <div class="col-md-6">
    @php 
    $totalLrgPrkngSpot=DB::table('aircraft_communications')->where('state','PARKED')->where('parking_spot','large')->count();
    $totalSmlPrkngSpot=DB::table('aircraft_communications')->where('state','PARKED')->where('parking_spot','small')->count();
@endphp
    <span class="SpotWrap">Large Parking Spots: <span class="prkngNum">@if($totalLrgPrkngSpot) {{$totalLrgPrkngSpot}} @else {{0}} @endif out of 5</span></span>
    </div>

    <div class="col-md-6">
    <span class="SpotWrap">Small Parking Spots: <span class="prkngNum">@if($totalSmlPrkngSpot) {{$totalSmlPrkngSpot}} @else {{0}} @endif out of 10</span></span>
    </div>

</div>

    <div class="no-gutters row">

<div class="col-md-12 tblWrap">

<table class="mb-0 table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Aircraft call sign</th>
                                                    <th>Type</th>
                                                    <th>State</th>
                                                    <th>Parking Spot</th>
                                                    <th>last updated</th>
                                                </tr>
                                            </thead>
                                            <tbody>
@php
$num=1;

@endphp

@if($fetchWeather){{ $fetchWeather }} @endif

@foreach($fetchWeather as $details)
<tr>
<th scope="row">{{ $num++ }}</td>
<td>@if($details->aircraft_call_sign) {{ $details->aircraft_call_sign }} @endif</td>
<td>@if($details->type) {{ $details->type }} @endif</td>
<td >@if($details->state) {{ $details->state }} @endif</td>
<td>@if($details->parking_spot) {{ $details->parking_spot }} @endif</td>
<td>@if($details->created_at) {{ $details->created_at }} @endif</td>
</tr>
@endforeach
    </tbody>
</table>
  <div class="col-md-12 pgntn">
  {{ $fetchWeather->links() }}
 </div>                                      
</div>

    </div>
    <div class="text-center d-block p-3 card-footer">
    </div>
</div>
                </div>
                
                </div>
    @include('dash_footer_upper')
            </div>
        </div>
    </div>

@include('dash_footer_drawers')

@include('dash_footer_bottom')

</body>

</html>
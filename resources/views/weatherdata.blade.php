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
    <div class="no-gutters row">
    <div class="row">
    <div class="col-md-12 m-3">
   <h4>Last fetched weather data</h4>
  </div>
  </div>
<div class="col-md-12 tblWrap">

<table class="mb-0 table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>description</th>
                                                    <th>temperature</th>
                                                    <th>visibility</th>
                                                    <th>wind</th>
                                                    <th>last updated</th>
                                                    <th>Country/City</th>
                                                </tr>
                                            </thead>
                                            <tbody>
@php
$num=1;
$fetchWeather= App\weatherinfo::orderBy('id', 'desc')->paginate(5);
@endphp

@foreach($fetchWeather as $details)

<tr>
<th scope="row">{{ $num++ }}</td>
<td>{{ $details->description }}</td>
<td>{{ $details->temperature }}</td>
<td >{{ $details->visibility }}</td>
<td>speed: {{ $details->wind_speed }}
    <br />
    degree: {{ $details->wind_deg }}
</td>
<td>{{ $details->created_at }}
</td>
<td>{{ $details->city }}</td>
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
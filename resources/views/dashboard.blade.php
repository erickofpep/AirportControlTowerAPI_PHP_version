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
        
    @if ($message = Session::get('success'))
    <div class="alert alert-success col-sm-12 msgAlrts">
        <p>{{ $message }} {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
    </div>
 @endif
 
 @include('aircraft_comms')

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
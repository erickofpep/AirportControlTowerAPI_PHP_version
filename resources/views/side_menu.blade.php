<div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                    app-header header-shadow
                        <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
</button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
</button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
<button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
<span class="btn-icon-wrapper">
<i class="fa fa-ellipsis-v fa-w-6"></i>
</span>
                    </button>
                    </span>
                </div>
        <div class="scrollbar-sidebar">
        
        <div class="dropdown-menu-header prflWrap">
           <div class="dropdown-menu-header-inner bg-info Bgrnd">
               <div class="menu-header-image opacity-2" style="background-image: url('assets/images/city3.jpg');"></div>
                <div class="menu-header-content text-left">
                  <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                     <div class="widget-content-left mr-3">
                <img width="42" class="rounded-circle" src="assets/images/1NoImg01.png" alt="">    
                       
                         </div>
                       <div class="widget-content-left">
                      <div class="widget-heading">
                        @if ( auth()->user()->firstname ) 
                        {{ auth()->user()->firstname }} 
                        @endif</div>
                        <div class="widget-subheading opacity-8">@if ( auth()->user()->firstname ){{ auth()->user()->lastname }} @endif</div>
                        </div>
                       <div class="widget-content-right mr-2"><a href="{{ route('logout') }}" title="Logout">
                       <button class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</button></a>
                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf</form>
                       </div>
                      </div>
                     </div>
                   </div>
                 </div>
                </div>
                                            
        <div class="app-sidebar__inner">
            
        <ul class="vertical-nav-menu">
            <li class="app-sidebar__heading">Menu</li>
<!--
            <li>
            <a href="{{ route('dashboard') }}">
<i class="metismenu-icon pe-7s-settings"></i>Home
<i class="metismenu-state-icon caret-left"></i>
</a></li>
-->
<li><a href="{{ route('dashboard') }}">
 <i class="metismenu-icon pe-7s-cloud"></i>Aircraft communications
<i class="metismenu-state-icon caret-left"></i>
</a></li>

<li><a href="{{ route('weatherdata') }}">
 <i class="metismenu-icon pe-7s-cloud"></i>Weather data
<i class="metismenu-state-icon caret-left"></i>
</a></li>
<li><a href="#">
 <i class="metismenu-icon pe-7s-info"></i>Parking overview
<i class="metismenu-state-icon caret-left"></i>
</a></li>


                        </ul>
                    </div>
                </div>
            </div>
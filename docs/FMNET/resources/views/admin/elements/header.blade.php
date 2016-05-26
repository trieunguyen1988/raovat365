{{--*/ $controller = Route::current()->getUri() /*--}}
<header class="navbar navbar-default navbar-static-top">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a class="navbar-brand" href="#">{{trans('admin/common.PAGE_TITLE')}}</a>
        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="ti-view-grid"></i>
        </a>        
    </div>
    <!-- end: NAVBAR HEADER -->
    <!-- start: NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-right pull-left">
            <li class="dropdown {{(strpos($controller,'user')) !== FALSE?'open':''}}">
                <a href="{!!url('admin/user')!!}" class="dropdown-toggle">
                    <i class="ti-user"></i> {{trans('admin/common.USER_MANAGEMENT')}}
                </a>
            </li>
        </ul>
        <ul class="nav navbar-right pull-left">
            <li class="dropdown {{(strpos($controller,'shop')) !== FALSE?'open':''}}">
                <a href="{!!url('admin/shop')!!}" class="dropdown-toggle" aria-expanded='{{(strpos($controller,'shop')) !== FALSE?'true':'false'}}'>
                    <i class="ti-archive"></i> {{trans('admin/common.SHOP_MANAGEMENT')}}
                </a>
            </li>
        </ul>
        <ul class="nav navbar-right pull-left">
            <li class="dropdown {{(strpos($controller,'account')) !== FALSE?'open':''}}">
                <a href="{!!url('admin/account')!!}" class="dropdown-toggle" aria-expanded=''>
                    <i class="ti-settings"></i> {{trans('admin/common.ACCOUNT_MANAGEMENT')}}
                </a>
            </li>
        </ul>
        <ul class="nav navbar-right">
            <!-- start: LANGUAGE SWITCHER -->
            <li class="dropdown">
                <a href="{!!url('admin/logout')!!}" class="dropdown-toggle">
                    <i class="ti-arrow-right"></i> {{trans('common.USER_LOGOUT')}}
                </a>
            </li>
        </ul>
        <!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
        <div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
        <!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
    </div>
    <!-- end: NAVBAR COLLAPSE -->
</header>
{{--*/ $controller = Route::current()->getUri() /*--}}
<div class="sidebar-container ps-container">
<nav class="ng-scope">
@if(strcmp($controller,'admin/user') == 0)
<form action="{{ url('admin/user') }}" method="GET" id="search_form">
<div class="padding-10" style="color: white">
    <h4 style="color: white">{{trans('admin/user.SEARCH_CONDITION_TITLE')}}</h4>
    <span>{{trans('admin/user.COMPANY_NAME')}}</span>
    <input type="text" class="form-control margin-bottom-10" name="search_company_name" value="{{old('search_company_name')}}"/>
    <span>{{trans('admin/user.PERSON_IN_CHARGE')}}</span>
    <input type="text" class="form-control margin-bottom-10" name="search_user_name" value="{{old('search_user_name')}}"/>
    <span>{{trans('admin/user.TEL')}}</span>
    <input type="text" class="form-control margin-bottom-10" name="search_tel" value="{{old('search_tel')}}"/>
    <span>{{trans('admin/common.MAIL_ADDRESS')}}</span>
    <input type="text" class="form-control" name="search_email" value="{{old('search_email')}}"/>
    <div class="clearfix margin-top-10">
        <button id="submit_btn" type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-btn fa-search"></i> {{trans('admin/common.BTN_SEARCH')}}
        </button>
    </div>
    <div class="clearfix margin-top-10">
        <a href="{{ url('admin/user/download').'?'.http_build_query($params, '', "&") }}" class="btn btn-primary pull-right">
            <i class="fa fa-btn fa-download"></i> {{trans('admin/common.BTN_CSV_OUTPUT')}}
        </a>
    </div>
</div>
@elseif(strcmp($controller,'admin/user/edit') == 0)
<ul class="main-navigation-menu ng-scope margin-top-0 margin-bottom-0 no-border">
    <li>
		<a href="{!!url('admin/shop?userid='.$userid_de)!!}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-list"></i>
				</div>
				<div class="item-inner">
					<span class="title ng-scope">{{trans('admin/user.USER_SHOP_LIST_MENU')}}</span>
				</div>
			</div>
		</a>
	</li>
</ul>
@elseif(strcmp($controller,'admin/shop') == 0)
<form action="{{ url('admin/shop') }}" method="GET" id="search_form">
<div class="padding-10" style="color: white">
    <h4 style="color: white">{{trans('admin/user.SEARCH_CONDITION_TITLE')}}</h4>
    <span>{{trans('admin/shop.SHOP_ID')}}</span>
    <input type="text" class="form-control margin-bottom-10" name="search_shop_id" value="{{old('search_shop_id')}}"/>
    <span>{{trans('admin/shop.SHOP_NAME')}}</span>
    <input type="text" class="form-control margin-bottom-10" name="search_shop_name" value="{{old('search_shop_name')}}"/>
    <span>{{trans('admin/shop.EXPIRED_DATE')}}</span>    
    <div class="input-group input-daterange">
        <input type="text" class="form-control datepicker" name="search_from_trial_period" value="{{old('search_from_trial_period')}}">
        <span class="input-group-addon bg-primary">〜</span>
        <input type="text" class="form-control datepicker" name="search_to_trial_period" value="{{old('search_to_trial_period')}}">
    </div>   
    <div class="clearfix margin-top-10">
        <button id="submit_btn" type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-btn fa-search"></i> {{trans('admin/common.BTN_SEARCH')}}
        </button>
    </div>
</div>
@endif
</nav>
</div>
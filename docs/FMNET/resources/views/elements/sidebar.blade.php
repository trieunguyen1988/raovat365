{{--*/ $controller = Route::current()->getUri() /*--}}
<div class="sidebar-container ps-container">
<nav class="ng-scope">
@if(strpos($controller,'shop') !== FALSE)
<ul class="main-navigation-menu ng-scope margin-top-0 margin-bottom-0 no-border">
    <li {{('shop' == $controller)?'class=active':''}}>
		<a href="{!!url('shop')!!}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-list"></i>
				</div>
				<div class="item-inner">
					<span class="title ng-scope">{{trans('shop.LEFT_MENU_SHOP_LIST')}}</span>
				</div>
			</div>
		</a>
	</li>
	<li {{('shop/create' == $controller)?'class=active':''}}>
		<a href="{!!url('shop/create')!!}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-pencil-alt"></i>
				</div>
				<div class="item-inner">
					<span class="title ng-scope">{{trans('shop.LEFT_MENU_SHOP_REGISTER')}}</span>
				</div>
			</div>
		</a>
	</li>
</ul>
@elseif(strpos($controller,'user') !== FALSE)
<ul class="main-navigation-menu ng-scope margin-top-0 margin-bottom-0 no-border">
    <li {{('user/edit' == $controller)?'class=active':''}}>
		<a href="{!!url('user/edit')!!}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-pencil-alt"></i>
				</div>
				<div class="item-inner">
					<span class="title ng-scope">{{trans('user.LEFT_MENU_EDIT')}}</span>
				</div>
			</div>
		</a>
	</li>
	<li {{('user/payment' == $controller)?'class=active':''}}>
		<a href="{!!url('user/payment')!!}">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-credit-card"></i>
				</div>
				<div class="item-inner">
					<span class="title ng-scope">{{trans('user.LEFT_MENU_PAYMENT')}}</span>
				</div>
			</div>
		</a>
	</li>
</ul>
@endif
</nav>
</div>

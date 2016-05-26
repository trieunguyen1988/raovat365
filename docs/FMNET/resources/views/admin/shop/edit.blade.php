@extends('admin.layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <div class="box-register">
            <form class="form-horizontal" action="{{ url('admin/shop/edit') }}" method="POST">
                    @if (isset($error_message))
                    <div class="form-group has-error">
                        <label class="col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">{{ $error_message }}</label>
                    </div>
                    @endif
                    @if (isset($success_message))
                    <div class="form-group has-success">
                        <label class="col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">{{ $success_message }}</label>
                    </div>
                    @endif                    
                    <div class="form-group{{ $errors->has('shop_id') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('shop.SHOP_ID')}}</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <label class="control-label">{{$shop->shop_id}}</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('shop.SHOP_NAME')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <input type="text" class="form-control" name="shop_name" value="{{old('shop_name', $shop->shop_name)}}">
                            @if ($errors->has('shop_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('shop.EXPIRED_DATE')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <label class="control-label">{{!empty(strtotime($shop->trial_period))?date(DATE_FORMAT, strtotime($shop->trial_period)):''}}</label>
                        </div>
                    </div>                    
                    <div class="form-group{{ $errors->has('shop_password') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('shop.SHOP_PASSWORD')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <input type="password" class="form-control" name="shop_password" value="{{old('shop_password', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                            @if ($errors->has('shop_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>                        
                    </div>
                    <div class="form-group{{ $errors->has('shop_password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.SHOP_PASSWORD_CONFIRM')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <input type="password" class="form-control" name="shop_password_confirmation" value="{{old('shop_password_confirmation', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                            @if ($errors->has('shop_password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-10">
                            <button type="submit" class="btn btn-primary pull-right">{{trans('common.BTN_UPDATE')}}</button>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-10 margin-top-15">
                            <button type="button" class="btn btn-light-red pull-right">{{trans('shop.BTN_CANCEL_PREMIUM')}}</button>
                        </div>                        
                        <div class="col-md-9 col-sm-9 col-xs-10 margin-top-15">
                            <button type="button" class="btn btn-success pull-right">{{trans('shop.BTN_BECOME_PREMIUM')}}</button>
                        </div>                                                
                    </div>
                {!! csrf_field() !!}
                <input type="hidden" name="shopid" value="{{ $shopid }}">
            </form>
        </div>
    </div>
</div>
@endsection

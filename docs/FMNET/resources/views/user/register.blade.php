@extends('layouts.login')
@section('content')
<div class="row margin-top-10">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 margin-bottom-50">
        <h2>{{trans('common.PAGE_TITLE')}}</h2>
        <div class="box-register">
            <form class="form-horizontal" action="{{ url('user/register') }}" method="POST">
                <fieldset>
                    <legend>{{trans('user.REGISTRATION_INFORMATION_TITLE')}}</legend>
                    @if (isset($registration_errors))
                        <span class="help-block">
                            <strong>{{ $registration_errors }}</strong>
                        </span>
                    @else
                    <h5>{{trans('user.USER_REGISTRATION_INFORMATION_TITLE')}}</h5>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('common.MAIL_ADDRESS')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <label class="control-label">{{$email}}</label>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('common.PASSWORD')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('common.PASSWORD_CONFIRM')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <h5 class="margin-top-30 margin-bottom-30">{{trans('user.APP_LOGIN_INFO')}}</h5>
                    <div class="form-group{{ $errors->has('shop_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.SHOP_ID')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="text" class="form-control" name="shop_id" value="{{old('shop_id')}}">
                            @if ($errors->has('shop_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('shop_password') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.SHOP_PASSWORD')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="password" class="form-control" name="shop_password">

                            @if ($errors->has('shop_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('shop_password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.SHOP_PASSWORD_CONFIRM')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="password" class="form-control" name="shop_password_confirmation">

                            @if ($errors->has('shop_password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.COMPANY_NAME')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="text" class="form-control" name="company_name" value="{{old('company_name')}}">
                            @if ($errors->has('company_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.PERSON_IN_CHARGE')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="text" class="form-control" name="user_name" value="{{old('user_name')}}">
                            @if ($errors->has('user_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-sm-3 col-xs-10 control-label padding-right-0">{{trans('user.SHOP_NAME')}}</label>

                        <div class="col-md-6 col-sm-8 col-xs-10">
                            <input type="text" class="form-control" name="shop_name" value="{{old('shop_name')}}">
                            @if ($errors->has('shop_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> {{trans('common.BTN_REGISTER_COMPLETE')}}
                            </button>
                        </div>
                    </div>
                    @endif
                </fieldset>
                {!! csrf_field() !!}
                <input type="hidden" name="u" value="{{$email_en}}" />
                <input type="hidden" name="url" value="{{$uuid_en}}" />
            </form>
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                &copy; <span class="current-year"></span><span class="text-bold text-uppercase"> FMNet</span>. <span>All rights reserved</span>
            </div>
            <!-- end: COPYRIGHT -->
        </div>
    </div>
</div>
@endsection

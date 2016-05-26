@extends('layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <form class="form-horizontal" action="{{ url('user/edit') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);">
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
            @if (isset($change_mail_message))
            <div class="form-group has-success">
                <label class="col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">{{ $change_mail_message }}</label>
            </div>
            @endif                    
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('common.MAIL_ADDRESS')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="email" value="{{old('email', !empty($user->email)?$user->email:null)}}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('common.PASSWORD')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="password" class="form-control" name="password" value="{{old('password', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>                
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('common.PASSWORD_CONFIRM')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>                
            </div>
            <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.COMPANY_NAME')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="company_name" value="{{old('company_name', !empty($user->company_name)?$user->company_name:null)}}">
                    @if ($errors->has('company_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.PERSON_IN_CHARGE')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="user_name" value="{{old('user_name', !empty($user->user_name)?$user->user_name:null)}}">
                    @if ($errors->has('user_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>                
            </div>
            <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.TEL')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="tel" value="{{old('tel', !empty($user->tel)?$user->tel:null)}}">
                    @if ($errors->has('tel'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tel') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-10">
                    <button id="submit_btn" type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-btn fa-user"></i> {{trans('common.BTN_UPDATE')}}
                    </button>
                </div>
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
</div>
@endsection

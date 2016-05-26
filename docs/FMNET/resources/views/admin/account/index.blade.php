@extends('admin.layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <form class="form-horizontal" action="{{ url('admin/account') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);">
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
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/common.MAIL_ADDRESS')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="email" value="{{old('email', !empty($account->email)?$account->email:null)}}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('admin/common.REQUIRED')}}</span></div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/common.PASSWORD')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="password" class="form-control" name="password" value="{{old('password', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('admin/common.REQUIRED')}}</span></div>                
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/common.PASSWORD_CONFIRM')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation', PASSWORD_MASK)}}" onclick="javascript:$(this).select()">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('admin/common.REQUIRED')}}</span></div>                
            </div>
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-10">
                    <button id="submit_btn" type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-btn fa-user"></i> {{trans('admin/common.BTN_UPDATE')}}
                    </button>
                </div>
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
</div>
@endsection

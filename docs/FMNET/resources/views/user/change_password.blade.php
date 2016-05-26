@extends('layouts.login')
@section('content')
<div class="row margin-top-10">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 margin-bottom-50">
        <h2>{{trans('common.PAGE_TITLE')}}</h2>
        <div class="box-register">
            <form class="form-horizontal" action="{{ url('user/change_password') }}" method="POST">
                <fieldset>
                    <legend>{{trans('user.CHANGE_PASSWORD_TITLE')}}</legend>
                    @if (isset($reset_errors))
                        <span class="help-block">
                            <strong>{{ $reset_errors }}</strong>
                        </span>
                    @else
                    <div class="form-group">
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
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-key"></i> {{trans('user.BTN_CHANGE_PASSWORD')}}
                            </button>
                        </div>
                    </div>
                    @endif
                </fieldset>
                {!! csrf_field() !!}
                <input type="hidden" name="u" value="{{$email_en}}" />
                <input type="hidden" name="url" value="{{$uid_en}}" />
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

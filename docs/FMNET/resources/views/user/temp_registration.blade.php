@extends('layouts.login')
@section('content')
<div class="row margin-top-30 padding-top-30">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <form class="form-login" action="{{ url('user/temp_register') }}" method="POST" onsubmit="javascript:$('#temp_regist_btn').attr('disabled', true);">
                <fieldset>
                    <legend>{{trans('user.TEMP_REGISTRATION_TITLE')}}</legend>
                    @if (isset($registration_errors))
                    <div class="has-error">
                        <span class="help-block">
                            <strong>{{ $registration_errors }}</strong>
                        </span>
                    </div>                                
                    @endif
                    <label>{{trans('user.TEMP_REGISTRATION_NOTICE')}}</label>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="email" placeholder="{{trans('common.MAIL_ADDRESS')}}" value='{{ old('email') }}'>
                            <i class="fa ti-email"></i> </span>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif                                    
                    </div>                
                    <div class="form-actions">
                        <button id="temp_regist_btn" type="submit" class="btn btn-primary pull-right">
                            {{trans('user.TEMP_REGISTRATION_BUTTON')}} <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
                {!! csrf_field() !!}                       
            </form>
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                &copy; <span class="current-year"></span><span class="text-bold text-uppercase"> FMNet</span>. <span>All rights reserved</span>
            </div>
            <!-- end: COPYRIGHT -->
        </div>
        <!-- end: LOGIN BOX -->
    </div>
</div>
@endsection

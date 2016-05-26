@extends('layouts.login')

@section('content')
<div class="row margin-top-30 padding-top-30">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <form class="form-login" action="{{ url('user/register') }}" method="POST">
                <fieldset>
                    <legend>{{trans('user.CHANGE_MAIL_COMPLETE_TITLE')}}</legend>
                    @if (isset($error_message))
                        <span class="help-block">
                            <strong>{{ $error_message }}</strong><br>
                            <strong>{{ trans('user.TRY_AGAIN') }}</strong>
                        </span>
                    @else
                    <label>{{trans('user.CHANGE_MAIL_COMPLETE_NOTICE', array('email' => $email))}}</label>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-5">
                            <a href="{{url('login')}}">{{trans('user.LOGIN_TITLE')}}</a>
                        </div>
                    </div>
                    @endif
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

@extends('layouts.login')

@section('content')
<div class="row margin-top-30 padding-top-30">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <form class="form-login" action="{{ url('user/register') }}" method="POST">
                <fieldset>
                    <legend>{{trans('user.TEMP_REGISTRATION_COMPLETE_TITLE')}}</legend>
                    <label>{!!trans('user.TEMP_REGISTRATION_COMPLETE_NOTICE')!!}</label>
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

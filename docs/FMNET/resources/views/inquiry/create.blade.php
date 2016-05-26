@extends('layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <div class="box-register">
            <form class="form-horizontal" action="{{ url('inquiry') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);">
                    <div class="form-group">
                        @if (isset($error_message))
                        <div class="form-group has-error">
                            <label class="col-md-6 col-md-offset-3 col-sm-9 col-sm-offset-3">{{ $error_message }}</label>
                        </div>
                        @endif
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0"></label>
                        <label class="col-md-9">{!!trans('inquiry.INQUIRY_INFO')!!}</label>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('common.MAIL_ADDRESS')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <input type="text" class="form-control" name="email" value="{{old('email', $user->email)}}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('inquiry.INQUIRY_SUBJECT')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <input type="text" class="form-control" name="subject" value="{{old('subject')}}">
                            @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('inquiry_content') ? ' has-error' : '' }}">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('inquiry.INQUIRY_CONTENT')}}</label>

                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <textarea class="form-control height-200" name="inquiry_content">{{old('inquiry_content')}}</textarea>
                            @if ($errors->has('inquiry_content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inquiry_content') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('common.REQUIRED')}}</span></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-10">
                            <button id="submit_btn" type="submit" class="btn btn-primary pull-right">{{trans('inquiry.BTN_INQUIRY_SEND')}}</button>
                        </div>
                    </div>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>
</div>
@endsection

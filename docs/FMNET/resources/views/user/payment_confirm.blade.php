@extends('layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 margin-bottom-50">
        <form class="form-horizontal" action="{{ url('user/payment_finish') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);" id="payment-form">
            @if (isset($error_message))
            <div class="form-group has-error">
                <label class="col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">{{ $error_message }}</label>
            </div>
            @endif            
            <h4 class="text-center margin-bottom-15">{{trans('user.PAYMENT_CONTENT_TITLE')}}</h4>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{{trans('user.PAYMENT_AMOUNT')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label padding-5" style="background-color: #b7e1cd">{{'¥'.(isset($payment_amount)?number_format($payment_amount):'0')}}</label>
                </div>
            </div>                
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{{trans('user.NEXT_PAYMENT_DATE')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label" id="next_payment">{{$next_payment_date or ''}}</label>
                </div>
            </div>
            <div class="form-group">
            <h5 class="margin-top-15 margin-bottom-15 col-md-6 col-sm-6 col-xs-6 pull-left text-right">{{trans('user.CREDIT_CARD_INFO')}}</h5>
            </div>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{!!trans('user.CARD_NAME')!!}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label">{{$card_name or ''}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{{trans('user.CARD_COMPANY')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label">{{$card_company_name}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{!!trans('user.CARD_NUMBER')!!}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label">{{$card_number or ''}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{{trans('user.EXPIRED_DATE')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label pull-left">{{$card_month.trans('common.MONTH').$card_year.trans('common.YEAR')}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 col-sm-6 col-xs-6 control-label padding-right-0">{!!trans('user.SECURITY_CODE')!!}</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label">●●●</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button id="submit_btn" type="submit" class="btn btn-primary pull-right">{{trans('user.PERFORM_PAYMENT_BTN')}}</button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button id="back_btn" type="button" class="btn btn-primary pull-left">{{trans('common.BACK_BTN')}}</button>
                </div>                
            </div>
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{$token}}" />
            <input type="hidden" name="card_company" value="{{$card_company}}" />
            <input type="hidden" name="payment_amount" value="{{$payment_amount}}" />
            <input type="hidden" name="card_month" value="{{$card_month}}" />
            <input type="hidden" name="card_year" value="{{$card_year}}" />
            <input type="hidden" name="card_name" value="{{$card_name}}" />
            <input type="hidden" name="card_number" value="{{$card_number}}" />
            <input type="hidden" name="next_payment_date" value="{{$next_payment_date}}" />
            <input type="hidden" name="basic_plan_id" value="{{$basic_plan_id}}" />
        </form>
    </div>
</div>
<script>
        $('#back_btn').on('click', function(){
            window.location = "{!!url('user/payment')!!}";
        });
</script>
@endsection
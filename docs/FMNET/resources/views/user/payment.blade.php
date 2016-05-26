@extends('layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <form class="form-horizontal" action="{{ url('user/payment') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);" id="payment-form">
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
            <div class="form-group transfer-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.NEXT_PAYMENT_DATE')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <label class="control-label" id="next_payment_label"></label>
                </div>
            </div>
            <div class="form-group transfer-group{{ $errors->has('payment_amount') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.NEXT_PAYMENT_AMOUNT')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <label class="control-label" id="payment_amount_lable"></label>
                    @if ($errors->has('payment_amount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('payment_amount') }}</strong>
                        </span>
                    @endif                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.PAYMENT_METHOD')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    @foreach ($payment_method as $key=>$method)
                    <div class="radio clip-radio radio-primary">
                        <input type="radio" id="payment_method_{{$key}}" name="payment_method" value="{{$key}}" <?php echo $key==old('payment_method', $user->payment_method)?'checked':'' ?>>
                        <label for="payment_method_{{$key}}">{{$method}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group transfer-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.BASIC_PLAN')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    @foreach ($basic_plan as $key=>$item)
                    <div class="radio clip-radio radio-primary">
                        <input type="radio" id="basic_plan_{{$key}}" name="basic_plan_id" value="{{$key}}" <?php echo $key==old('basic_plan_id', $user->basic_plan_id)?'checked':'' ?>>
                        <label for="basic_plan_{{$key}}">{{$item['name']}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <fieldset id="card_info" class="transfer-group">
                <legend>{{trans('user.CREDIT_CARD_INFO')}}</legend>
                <div class="form-group{{ $errors->has('card_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{!!trans('user.CARD_NAME')!!}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="text" class="form-control" name="card_name" id="card_name" value="{{old('card_name')}}">
                        @if ($errors->has('card_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('card_company') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.CARD_COMPANY')}}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <select class="width-200 form-control" name="card_company">
                            <option disabled="disabled">{{trans('common.PLEASE_SELECT')}}</option>
                            @foreach ($card_type as $key=>$item)
                                <option value="{{$key}}" <?php echo $key==old('card_company')?'selected':'' ?>>{{$item}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('card_company'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_company') }}</strong>
                            </span>
                        @endif                         
                    </div>
                </div>
                <div class="form-group{{ $errors->has('card_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{!!trans('user.CARD_NUMBER')!!}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="text" class="form-control" id="card_number_input" value="">
                        @if ($errors->has('card_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('card_month') || $errors->has('card_year') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.EXPIRED_DATE')}}</label>
                    <div class="col-md-6 col-sm-6 col-xs-10">
                        <select class="width-100 form-control pull-left" name="card_month" id="card_month">
                            <option disabled="disabled" selected="selected">{{trans('common.MONTH')}}</option>
                            @foreach ($card_period['month'] as $key=>$item)
                                <option value="{{$key}}" <?php echo $key==old('card_month')?'selected':'' ?>>{{$item}}</option>
                            @endforeach
                        </select>
                        <label class="control-label pull-left">{{trans('common.MONTH').'/'}}</label>
                        <select class="width-100 form-control pull-left" name="card_year" id="card_year">
                            <option disabled="disabled" selected="selected">{{trans('common.YEAR')}}</option>
                            @foreach ($card_period['year'] as $key=>$item)
                                <option value="{{$key}}" <?php echo $key==old('card_year')?'selected':'' ?>>{{$item}}</option>
                            @endforeach
                        </select>
                        <label class="control-label pull-left">{{trans('common.YEAR')}}</label>
                        @if ($errors->has('card_month'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_month') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('card_year'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_year') }}</strong>
                            </span>
                        @endif                        
                    </div>
                </div>
                <div class="form-group{{ $errors->has('security_code') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{!!trans('user.SECURITY_CODE')!!}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="password" class="form-control width-200" name="security_code" id="security_code" value="" placeholder="●●●">                      
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>{{trans('user.TRANSFER_INFORMATION')}}</legend>
                <div class="form-group{{ $errors->has('payer') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{!!trans('user.TRANSFER_NAME')!!}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="text" class="form-control" name="payer" value="{{old('payer', $user->payer)}}">
                        @if ($errors->has('payer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('payer') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('payer_kana') ? ' has-error' : '' }}">
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{!!trans('user.TRANSFER_NAME_KANA')!!}</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="text" class="form-control" name="payer_kana" value="{{old('payer_kana', $user->payer_kana)}}">
                        @if ($errors->has('payer_kana'))
                            <span class="help-block">
                                <strong>{{ $errors->first('payer_kana') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button id="submit_btn" type="submit" class="btn btn-primary pull-right">{{trans('common.BTN_UPDATE')}}</button>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 transfer-group">
                    <button id="confirm_payment_btn" type="button" class="btn btn-primary pull-right margin-top-15">{{trans('user.PAY_BUTTON')}}</button>
                </div>
            </div>
            {!! csrf_field() !!}
            @foreach($basic_plan as $key=>$item)
                <input type="hidden" id="hidden_next_pay_date_{{$key}}" value="{{$item['next_pay_date']}}" />
                <input type="hidden" id="hidden_payment_amount_{{$key}}" value="{{$item['amount']}}" />
            @endforeach
            <input type="hidden" id="num_of_shop" value="{{count($shop_list)}}" />
            <input type="hidden" id="token" name="token" value=""/>
            <input type="hidden" id="next_payment_date" name="next_payment_date" value=""/>
            <input type="hidden" id="payment_amount" name="payment_amount" value=""/>
            <input type="hidden" id="card_number" name="card_number" value=""/>
            <input type="hidden" id="card_company_name" name="card_company_name" value=""/>
        </form>
    </div>
</div>
<script type="text/javascript" src="https://js.webpay.jp/v1/"></script>
<script>
    $(document).ready(function(){
        setPaymentInfo();
        setPaymentMethod(0);
    });
    $('input[name="payment_method"]').on('change', function(){
        setPaymentMethod(500);
    });
    $('input[name="basic_plan_id"]').on('change', setPaymentInfo);    
    $('#confirm_payment_btn').on('click', getUserToken);
    function getUserToken() {
        var card_number = $('#card_number_input').val().replace(/ /g,'');
        WebPay.setPublishableKey("{{WEBPAY_PUBLIC_KEY}}");
        WebPay.createToken({
            number: card_number,
            name: $('#card_name').val(),
            cvc: $("#security_code").val(),
            exp_month: $("#card_month").val(),
            exp_year: $("#card_year").val()
        }, webpayResponseHandler);
    }
    var webpayResponseHandler = function(status, response) {
        var form = $("#payment-form");
        if (response.error) {console.log(response.error);
            //Error alert
            alert(response.error.message);
        } else {
            $("#confirm_payment_btn").prop('disabled', true);
            $("#security_code").removeAttr("name");
            $("#card_number").val('*******************'+$("#card_number_input").val().substr($("#card_number_input").val().length - 4));
            $("#card_company_name").val(response.card.type);

            var token = response.id;
            $("#token").val(token);
            form.prop('action', "{{ url('user/payment_confirm') }}");
            form.get(0).submit();
        }
    };
</script>
@endsection
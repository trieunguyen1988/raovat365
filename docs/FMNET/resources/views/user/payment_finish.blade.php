@extends('layouts.master')
@section('content')
<div class="padding-top-15">
    <span class="display-table" style="margin: auto">
        <p><strong>{!!trans('user.PAYMENT_FINISH_INFO')!!}</strong></p>
        <p>{{trans('user.PAYMENT_DATE').': '}}<strong>{{date(DATE_TIME_FORMAT, $payment_result->created)}}</strong></p>
        <p>{{trans('user.PAYMENT_AMOUNT').': '}}<label class="control-label padding-5" style="background-color: #b7e1cd"><strong>¥{{number_format($payment_result->amount)}}</strong></label></p>
    </span>
</div>
@endsection

@extends('layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
        <div class="table-responsive">
    <table class="table table-bordered table-hover margin-bottom-0" id="sample-table-1">
        <thead>
            <tr class="success">
                <th class="center">{{trans('shop.SHOP_ID')}}</th>
                <th class="center">{{trans('shop.SHOP_NAME')}}</th>
                <th class="center">{{trans('shop.EXPIRED_DATE')}}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($shops))
            @foreach($shops as $shop)
            <tr>
                <td class="text-right"><a href="{!!url("shop/edit?shopid=".Crypt::encrypt($shop->shop_id))!!}">{{$shop->shop_id}}</a></td>
                <td class="text-right">{{$shop->shop_name}}</td>
                <td class="text-right">{{!empty(strtotime($shop->trial_period))?date(DATE_FORMAT, strtotime($shop->trial_period)):''}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="text-right">{!! $shops->links() !!}</div>
</div>
    </div>
</div>
{!! csrf_field() !!}
@endsection

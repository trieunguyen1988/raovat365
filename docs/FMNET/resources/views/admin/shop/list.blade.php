@extends('admin.layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
        <select class="width-200 form-control pull-right margin-bottom-10" name="sort_list" id="sort_list">
            @foreach ($sort_list as $key=>$item)
                <option value="{{$key}}" <?php echo $key==old('sort_list')?'selected':'' ?>>{{$item['name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
        <div class="table-responsive">
            <table class="table table-bordered table-hover margin-bottom-0" id="sample-table-1">
                <thead>
                    <tr class="success">
                        <th class="center">{{trans('admin/shop.SHOP_ID')}}</th>
                        <th class="center">{{trans('admin/shop.SHOP_NAME')}}</th>
                        <th class="center">{{trans('admin/shop.EXPIRED_DATE')}}</th>
                        <th class="center">{{trans('admin/shop.REGISTRATION_DATE')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($shops))
                    @foreach($shops as $shop)
                    <tr onclick="window.location='{!!url("admin/shop/edit?shopid=".Crypt::encrypt($shop->shop_id))!!}'">
                        <td class="text-right">{{$shop->shop_id}}</td>
                        <td class="text-right">{{$shop->shop_name}}</td>
                        <td class="text-right">{{!empty(strtotime($shop->trial_period))?date(DATE_FORMAT, strtotime($shop->trial_period)):''}}</td>
                        <td class="text-right">{{!empty(strtotime($shop->register_date))?date(DATE_FORMAT, strtotime($shop->register_date)):''}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="text-right">{!! $shops->appends($params)->links() !!}</div>
        </div>
    </div>
</div>
<input type="hidden" name="userid" value="{{old('userid')}}" />
</form>
<script>
    $('#sort_list').on('change', function(){
        $('#search_form').submit();
    });
</script>
{!! csrf_field() !!}
@endsection
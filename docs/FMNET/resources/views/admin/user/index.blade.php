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
    @if (isset($error_message))
    <div class="form-group has-error">
        <label class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">{{ $error_message }}</label>
    </div>
    @endif
    @if (isset($success_message))
    <div class="form-group has-success">
        <label class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">{{ $success_message }}</label>
    </div>
    @endif    
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">             
        <div class="table-responsive">
            <table class="table table-bordered table-hover margin-bottom-0" id="sample-table-1">
                <thead>
                    <tr class="success">
                        <th class="center">{{trans('admin/user.COMPANY_NAME')}}</th>
                        <th class="center">{{trans('admin/user.PERSON_IN_CHARGE')}}</th>          
                        <th class="center">{{trans('admin/user.TEL')}}</th>  
                        <th class="center">{{trans('admin/common.MAIL_ADDRESS')}}</th>                
                        <th class="center">{{trans('admin/user.NEXT_PAY_DATE')}}</th>
                        <th class="center">{{trans('admin/user.REGISTER_DATE')}}</th>                                
                    </tr>
                </thead>
                <tbody>
                    @if(count($users))
                    @foreach($users as $user)
                    <tr onclick="window.location='{!!url("admin/user/edit?userid=".Crypt::encrypt($user->user_id))!!}'">
                        <td class="text-right">{{$user->company_name}}</td>
                        <td class="text-right">{{$user->user_name}}</td>
                        <td class="text-right">{{$user->tel}}</td>
                        <td class="text-right">{{$user->email}}</td>
                        <td class="text-right">{{!empty(strtotime($user->next_pay_date))?date(DATE_FORMAT, strtotime($user->next_pay_date)):''}}</td>
                        <td class="text-right">{{!empty(strtotime($user->register_date))?date(DATE_FORMAT, strtotime($user->register_date)):''}}</td>                
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="text-right">{!! $users->appends($params)->links() !!}</div>
        </div>
    </div>
</div>
</form>
<script>
    $('#sort_list').on('change', function(){
        $('#search_form').submit();
    });
</script>
@endsection

@extends('admin.layouts.master')
@section('content')
<div class="padding-top-20">
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin-bottom-50">
        <form class="form-horizontal" action="{{ url('admin/user/edit') }}" method="POST" onsubmit="javascript:$('#submit_btn').attr('disabled', true);">
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
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/common.MAIL_ADDRESS')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="email" value="{{old('email', !empty($user->email)?$user->email:null)}}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('admin/common.REQUIRED')}}</span></div>
            </div>
            <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.COMPANY_NAME')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="company_name" value="{{old('company_name', !empty($user->company_name)?$user->company_name:null)}}">
                    @if ($errors->has('company_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('user.PERSON_IN_CHARGE')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="user_name" value="{{old('user_name', !empty($user->user_name)?$user->user_name:null)}}">
                    @if ($errors->has('user_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0"><span class="label label-danger" style="line-height: 32px;">{{trans('admin/common.REQUIRED')}}</span></div>
            </div>
            <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.TEL')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="tel" value="{{old('tel', !empty($user->tel)?$user->tel:null)}}">
                    @if ($errors->has('tel'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tel') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('payer') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.PAYER')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="payer" value="{{old('payer', !empty($user->payer)?$user->payer:null)}}">
                    @if ($errors->has('payer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('payer') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('payer_kana') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.PAYER_KANA')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control" name="payer_kana" value="{{old('payer_kana', !empty($user->payer_kana)?$user->payer_kana:null)}}">
                    @if ($errors->has('payer_kana'))
                        <span class="help-block">
                            <strong>{{ $errors->first('payer_kana') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('next_pay_date') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.NEXT_PAY_DATE')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <p class="input-group input-append datepicker date width-200">
                        <input type="text" class="form-control"width name="next_pay_date" value="{{old('next_pay_date', !empty($user->next_pay_date)?date(DATE_FORMAT, strtotime($user->next_pay_date)):null)}}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-calendar"></i></button>
                        </span>
                    </p>
                    @if ($errors->has('next_pay_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('next_pay_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('next_pay_amount') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.NEXT_PAY_AMOUNT')}}</label>
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <input type="text" class="form-control width-200 text-right" name="next_pay_amount" value="{{old('next_pay_amount', $user->next_pay_amount)}}">
                    @if ($errors->has('next_pay_amount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('next_pay_amount') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('basic_plan_id') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.BASIC_PLAN')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    @foreach ($basic_plan as $key=>$item)
                    <div class="radio clip-radio radio-primary">
                        <input type="radio" id="basic_plan_{{$key}}" name="basic_plan_id" value="{{$key}}" <?php echo $key==old('basic_plan_id', $user->basic_plan_id)?'checked':'' ?>>
                        <label for="basic_plan_{{$key}}">{{$item['name']}}</label>
                    </div>
                    @endforeach
                    @if ($errors->has('basic_plan_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('basic_plan_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('memo') ? ' has-error' : '' }}">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label padding-right-0">{{trans('admin/user.MEMO')}}</label>

                <div class="col-md-6 col-sm-6 col-xs-10">
                    <textarea class="form-control height-200" name="memo">{{old('memo', $user->memo)}}</textarea>
                    @if ($errors->has('memo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('memo') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-10">
                    <button id="delete_user_btn" type="button" class="btn btn-danger pull-right margin-left-20">
                        <i class="fa fa-btn"></i> {{trans('admin/common.BTN_DELETE')}}
                    </button>
                    <button id="submit_btn" type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-btn fa-user"></i> {{trans('admin/common.BTN_UPDATE')}}
                    </button>
                </div>
            </div>
            <input type="hidden" name="userid" value="{{$userid}}" />
            {!! csrf_field() !!}
        </form>
    </div>
</div>
<form id="delete_user" action="{{ url('admin/user/delete') }}" method="POST">
    <input type="hidden" name="userid" value="{{$userid}}" />
    {!! csrf_field() !!}
</form>
<script>
    $('#delete_user_btn').on('click', function(){
        if(confirm("{{trans('admin/user.USER_DELETE_CONFIRM_MESSAGE')}}")) {
            $('#delete_user').submit();
        }
    });
</script>
@endsection

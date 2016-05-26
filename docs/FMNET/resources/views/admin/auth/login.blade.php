@extends('admin.layouts.login')
@section('content')
		<!-- start: LOGIN -->
		<div class="row margin-top-30 padding-top-30">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<!-- start: LOGIN BOX -->
				<div class="box-login">
                    <form class="form-login" action="{{ url('/admin/login') }}" method="POST">
						<fieldset>
							<legend>{{trans('common.LOGIN_TITLE')}}</legend>
                            @if (isset($login_errors))
                            <div class="has-error">
                                <span class="help-block">
                                    <strong>{{ $login_errors }}</strong>
                                </span>
                            </div>
                            @endif
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<span class="input-icon">
									<input type="text" class="form-control" name="email" placeholder="{{trans('common.MAIL_ADDRESS')}}" value='{{ old('email') }}'>
									<i class="fa ti-email"></i> </span>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
							</div>
							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="{{trans('common.PASSWORD')}}">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
									<i class="fa fa-lock"></i></span>
							</div>
                            <div class="form-group">
                                <span class="input-icon">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> {{trans('user.REMEMBER_LOGIN')}}
                                        </label>
                                    </div>
                                </span>
                            </div>
							<div class="form-actions">
								<button type="submit" class="btn btn-danger pull-right">
									{{trans('common.LOGIN_TITLE')}} <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
							<div class="new-account">
                                <a href="{!!url('admin/account/reset_password')!!}">{{trans('admin/user.FORGOT_PASSWORD')}}</a>
							</div>
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
		<!-- end: LOGIN -->
@endsection

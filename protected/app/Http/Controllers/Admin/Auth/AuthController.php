<?php

namespace App\Http\Controllers\Admin\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $guard = 'admin';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest', ['except' => 'logout']);
    }
    public function login(Request $request)
    {
        //$datas = $request->session()->all();
        $template = 'admin.auth.login';
        $data['title'] = trans('common.LOGIN_TITLE');
        $request->flash();
        if($request->isMethod('get')) {
            return view($template, $data);
        }
        else if($request->isMethod('post')) {
            $validate = $this->loginValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view($template, $data);
            }
            //Do login
            $login  = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if(\Auth::guard('admin')->attempt($login, isset($request->remember)?true:false)){
                return redirect('admin');
            } else {
                $data['login_errors'] = trans('auth.failed');
                return view($template, $data);
            }
        }
    }
    /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
    }
}

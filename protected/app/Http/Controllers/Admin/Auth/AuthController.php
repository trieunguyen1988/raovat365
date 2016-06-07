<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Models\Admin\Login;
// use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\LoginRequest;

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
    // protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
//        $this->middleware('guest', ['except' => 'logout']);
        $this->auth = $auth;
        $this->redirectPath = 'admin';
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    public function getLogin()
    {
        //$datas = $request->session()->all();
        $template = 'admin.auth.login';
        $data['title'] = trans('common.LOGIN_TITLE');
        return view($template, $data);
    }

    public function postLogin(LoginRequest $request){
        $auth = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if (\Auth::guard('admin')->attempt($auth)){
            $admin = \Auth::guard('admin')->login();
            echo '<pre/>';
            print_r($admin);
        } else {
            echo 'Login thất bại';
        }
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function loginValidator(array $data)
    // {
    //     return Validator::make($data, [
    //         'email' => 'required|email|max:255',
    //         'password' => 'required',
    //     ]);
    // }
}

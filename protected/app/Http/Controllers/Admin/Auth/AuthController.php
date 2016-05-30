<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
//use Symfony\Component\HttpFoundation\Request;
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
    public function getLogin()
    {
        //$datas = $request->session()->all();
        $template = 'admin.auth.login';
        $data['title'] = trans('common.LOGIN_TITLE');
        return view($template, $data);
    }

    public function postLogin(LoginRequest $request){
        die('fffff');
        echo '<pre/>';
        print_r($request);
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

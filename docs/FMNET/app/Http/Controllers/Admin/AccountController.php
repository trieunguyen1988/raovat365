<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ErrorHelper;
use Illuminate\Support\Facades\DB;
use App\AdminUser;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = trans('admin/common.ACCOUNT_MANAGEMENT');
        $errorHelper = new ErrorHelper;
        $template = 'admin/account.index';
        $user = AdminUser::first();
        $data['account'] = $user;
        if($request->isMethod('get')) {
            $request->flush();
            return view($template, $data);
        }
        else if ($request->isMethod('post')) {
            $request->flash();
            //Validates data
            $validate = $this->editValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view($template, $data);
            }
            else {
                if($user) {
                    //If change email
                    if($request->email != $user->email) {
                            $user->email = $request->email;
                    }
                    //If change password
                    if($request->password != PASSWORD_MASK) {
                        $user->password = bcrypt($request->password);
                    }
                    try {
                        //Begin transaction
                        DB::beginTransaction();
                        $user->save();
                        //Commit DB
                        DB::commit();
                        $data['success_message'] = trans('admin/user.UPDATE_SUCCESS');
                    } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                        DB::rollback();
                        $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                        return view($template, $data);
                    }
                    catch (\Swift_TransportException $e) {//Send mail error
                        DB::rollback();
                        $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SEND_MAIL_ERROR);
                        return view($template, $data);
                    }
                }
                return view($template, $data);
            }
        }
    }
    public function resetPassword(Request $request)
    {
        $errorHelper = new ErrorHelper();
        $data['title'] = trans('admin/user.RESET_PASSWORD_TITLE');
        $template = 'admin/account.reset_password';
        $request->flash();
        if($request->isMethod('get')) {
            return view($template, $data);
        }
        else if($request->isMethod('post')) {
            $email = $request->email;
            $validate = $this->resetPasswordValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view($template, $data);
            }
            //If email exists
            $userModel = new User();
            $user = $userModel->getByEmail($email);
            if(!$user) {
                $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_EMAIL_NOT_EXISTS);
                return view($template, $data);
            }
            /*Send mail reset password*/
            try {
                Mail::send('email_templates.reset_password', ['user'=>$user], function ($m) use ($user) {
                    $m->from('admin@fmnet.com', 'FMNet');
                    $m->to($user->email)->subject(trans('common.MAIL_RESET_PASSWORD_SUBJECT'));
                });
            } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                return view($template, $data);
            }
            catch (\Swift_TransportException $e) {//Send mail error
                $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SEND_MAIL_ERROR);
                return view($template, $data);
            }
            catch (\Exception $e) {// System error
                $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
                return view($template, $data);
            }
            $data['title'] = trans('user.RESET_PASSWORD_COMPLETE_TITLE');
            return view('user.reset_password_complete', $data);
        }
    }
    /**
     * Get a validator for an incoming edit request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function editValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:20|confirmed',
        ]);
    }
    /**
     * Get a validator for an incoming reset password request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function resetPasswordValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
        ]);
    }    
}
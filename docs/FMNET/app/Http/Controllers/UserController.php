<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use App\TempRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\ErrorHelper;
use Mail;
use App\Shop;
use Illuminate\Support\Facades\DB;
use WebPay\WebPay;

class UserController extends Controller
{
    public function tempRegister(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $data['title'] = trans('user.TEMP_REGISTRATION_TITLE');
        $request->flash();
        if($request->isMethod('get')) {
            return view('user.temp_registration', $data);
        }
        else if($request->isMethod('post')) {
            $email = $request->email;
            $validate = $this->tempRegistrationValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view('user.temp_registration', $data);
            }
            //If email exists
            $user = new User();
            if($user->checkEmailExists($email)) {
                $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS);
                return view('user.temp_registration', $data);
            }
            /*Do registration*/
            //Create temp user
            $currentTime = \Carbon\Carbon::now();
            $expired_at = date_add($currentTime, date_interval_create_from_date_string(FMNET_TEMP_REGISTRATION_EXPIRED_HOURS.' hour'));
            $tempRegistration = new TempRegistration();
            $tempRegistration->email = $email;
            $tempRegistration->uuid = getUUIDv4();
            $tempRegistration->expired_at = $expired_at;
            try {
                if($tempRegistration->save()) {
                    //Send mail
                    Mail::send('email_templates.register', ['user'=>$tempRegistration], function ($m) use ($tempRegistration) {
                        $m->from('admin@fmnet.com', 'FMNet');
                        $m->to($tempRegistration->email)->subject('Please confirm registration!');
                    });
                }
                $tempRegistration->expired_at = gmdate(DATE_TIME_FORMAT_DB,  $tempRegistration->expired_at->getTimestamp());
            } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                return view('user.temp_registration', $data);
            }
            catch (\Swift_TransportException $e) {//Send mail error
                $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SEND_MAIL_ERROR);
                return view('user.temp_registration', $data);
            }
            catch (\Exception $e) {// System error
                $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
                return view('user.temp_registration', $data);
            }
            $data['title'] = trans('user.TEMP_REGISTRATION_COMPLETE_TITLE');
            return view('user.temp_registration_complete', $data);
        }
    }

    public function register(Request $request)
    {
        $template = 'user.register';
        $errorHelper = new ErrorHelper;
        $data['title'] = trans('user.REGISTRATION_INFORMATION_TITLE');
        //Get parameters
        $uuid  = isset($request->url)?$request->url:'';
        $email = isset($request->u)?$request->u:'';
        $data['email_en'] = $email;
        $data['uuid_en'] = $uuid;
        //Decrypt data
        try {
            $uuid = Crypt::decrypt($uuid);
            $email = Crypt::decrypt($email);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
            return view($template, $data);
        }
        //Check token data
        if(empty($uuid) || empty($email)) {
            $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_MISSING_PARAMETER);
            return view($template, $data);
        }
        //Check registration data
        $tempRegistration = TempRegistration::where('email', $email)
                                            ->where('uuid', $uuid)
                                            ->where('used_flg', 0)
                                            ->where('expired_at','>', \Carbon\Carbon::now()->toDateTimeString())
                                            ->first();
        if($tempRegistration) {
            $data['email'] = $email;
            $request->flash();
            if($request->isMethod('get')) {//Return registration screen
                return view($template, $data);
            }
            else if($request->isMethod('post')) {// Do registration
                //Validates data
                $validate = $this->registrationValidator($request->all());
                if($validate->fails()) {
                    $data['errors'] = $validate->errors();
                    return view($template, $data);
                }
                else {
                    //Save user
                    $user = new User();
                    $user->email         = $email;
                    $user->password      = bcrypt($request->password);
                    $user->company_name  = isset($request->company_name)?$request->company_name:'';
                    $user->user_name     = isset($request->user_name)?$request->user_name:'';
                    $user->register_date = gmdate(DATE_TIME_FORMAT_DB);
                    //Save shop
                    if($user->save()) {
                        //Create temp user
                        $currentTime = \Carbon\Carbon::now();
                        $expired_at = date_add($currentTime, date_interval_create_from_date_string(FMNET_SHOP_EXPIRED_DAYS.' day'));
                        $shop = new Shop();
                        $shop->shop_id        = $request->shop_id;
                        $shop->shop_password  = md5($request->shop_password);
                        $shop->user_id        = $user->user_id;
                        $shop->shop_name      = isset($request->shop_name)?$request->shop_name:'';
                        $shop->account_status = FMNET_SHOP_TRIAL_CODE;
                        $shop->trial_period   = $expired_at;
                        $shop->register_date  = gmdate(DATE_TIME_FORMAT_DB);
                        $shop->save();
                        //Temp registration
                        $tempRegistration->used_flg = 1;
                        $tempRegistration->save();
                    }
                    $data['title'] = trans('user.REGISTRATION_COMPLETE_TITLE');
                    return view('user.registration_complete', $data);
                }
            }
            else {//Return error
                $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_WRONG_TOKEN);
                return view($template, $data);
            }
        }
        else {
            $data['registration_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_WRONG_TOKEN);
            return view($template, $data);
        }
    }

    public function edit(Request $request)
    {
        $data['title'] = trans('user.EDIT_PAGE');
        $errorHelper = new ErrorHelper;
        $template = 'user.edit';
        $user = \Auth::user();
        $data['user'] = $user;
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
                $user_data = User::find($user->user_id);
                if($user_data) {
                    //If change email
                    if($request->email != $user->email) {
                        if($this->checkMailExists($request->email)) {
                            $message_bag = new \Illuminate\Support\MessageBag();
                            $message_bag->add('email', $errorHelper->getErrorMessage(FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS));
                            $data['errors'] = $message_bag;
                            return view($template, $data);
                        }
                        else {
                            $user_data->temp_email = $request->email;
                            $currentTime = \Carbon\Carbon::now();
                            $expired_at = date_add($currentTime, date_interval_create_from_date_string(FMNET_EMAIL_CHANGE_EXPIRED_HOURS.' hour'));
                            $user_data->temp_email_expired_at = $expired_at;
                            $isSendMail = true;
                        }
                    }
                    if($request->password != PASSWORD_MASK) {
                        $user_data->password = bcrypt($request->password);
                    }
                    $user_data->user_name = $request->user_name;
                    $user_data->company_name = $request->company_name;
                    $user_data->tel = $request->tel;
                    try {
                        //Begin transaction
                        DB::beginTransaction();
                        $user_data->save();
                        //Send mail
                        if(!empty($isSendMail)) {
                            Mail::send('email_templates.change_mail', ['user'=>$user_data], function ($m) use ($user_data) {
                                $m->from('admin@fmnet.com', 'FMNet');
                                $m->to($user_data->temp_email)->subject('Please confirm for email changing!');
                            });
                            $data['change_mail_message'] = trans('user.CHANGE_MAIL_NOTICE', array('email'=> $user_data->temp_email));
                        }
                        //Commit DB
                        DB::commit();
                        $data['success_message'] = trans('user.UPDATE_SUCCESS');
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

    public function changeMail(Request $request)
    {
        $template = 'user.change_email_complete';
        $errorHelper = new ErrorHelper;
        $data['title'] = trans('user.CHANGE_MAIL_COMPLETE_TITLE');
        $userId  = isset($request->ui)?$request->ui:'';
        $tempEmail = isset($request->te)?$request->te:'';
        //Decrypt data
        try {
            $userId = Crypt::decrypt($userId);
            $tempEmail = Crypt::decrypt($tempEmail);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
            return view($template, $data);
        }
        //Check request data
        if(empty($userId) || empty($tempEmail)) {
            $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_MISSING_PARAMETER);
            return view($template, $data);
        }
        //Check request change mail data
        $user = User::where('temp_email', $tempEmail)
                                            ->where('user_id', $userId)
                                            ->where('del_flg', 0)
                                            ->where('temp_email_expired_at','>', \Carbon\Carbon::now()->toDateTimeString())
                                            ->first();
        if($user) {
            $user->email = $tempEmail;
            $user->temp_email = null;
            $user->temp_email_expired_at = null;
            try{
                $user->save();
                $data['email'] = $tempEmail;
                return view($template, $data);
            } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                return view($template, $data);
            }
        }
        else {
            $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_WRONG_TOKEN);
            return view($template, $data);
        }
    }

    public function payment(Request $request)
    {
        $template = 'user.payment';
        $data['title'] = trans('user.CHANGE_PAYMENT_TITLE');
        $data['payment_method'] = getPaymentMethod();
        $data['card_type']      = getCardType();
        $data['card_period']    = getCardPeriodData(NUM_OF_CARD_PERIOD_YEAR);
        $user_login = \Auth::user();
        $user = User::find($user_login->user_id);
        $shop = new Shop();
        $data['shop_list'] = $shop->getShopsListForPayment($user_login->user_id);
        $data['basic_plan'] = getBasicPlan($user->last_pay_date);
        if($user) {
            $data['user'] = $user;
        }
        if($request->isMethod('post')) {
            $request->flash();
            $validate = $this->paymentValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view($template, $data);
            }
            if(isset($request->payment_method)) {
                $user->payment_method = $request->payment_method;
            }
            if(isset($request->basic_plan_id)) {
                $user->basic_plan_id = $request->basic_plan_id;
            }
            $user->payer = $request->payer;
            $user->payer_kana = $request->payer_kana;
            $user->save();
            $data['success_message'] = trans('user.UPDATE_SUCCESS');
        }
        return view($template, $data);
    }

    public function paymentConfirm(Request $request)
    {
        $template = 'user.payment_confirm';
        $data = $request->all();
        $data['title'] = trans('user.PAYMENT_CONFIRM_TITLE');
        $data['payment_method'] = getPaymentMethod();
        $data['card_type']      = getCardType();
        $data['card_period']    = getCardPeriodData(NUM_OF_CARD_PERIOD_YEAR);
        $user_login = \Auth::user();
        $user = User::find($user_login->user_id);
        $shop = new Shop();
        $data['shop_list'] = $shop->getShopsListForPayment($user_login->user_id);
        $data['basic_plan'] = getBasicPlan($user->last_pay_date);
        if($user) {
            $data['user'] = $user;
        }
        if($request->isMethod('post')) {
            $request->flash();
            $validate = $this->paymentConfirmValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
                return view('user.payment', $data);
            }
        }
        return view($template, $data);
    }

    public function paymentFinish(Request $request)
    {
        $template = 'user.payment_finish';
        $data = $request->all();
        $data['title'] = trans('user.PAYMENT_CONFIRM_TITLE');

        $data['payment_method'] = getPaymentMethod();
        $data['card_type']      = getCardType();
        $data['card_period']    = getCardPeriodData(NUM_OF_CARD_PERIOD_YEAR);
        $user_login = \Auth::user();
        $user = User::find($user_login->user_id);
        $shop = new Shop();
        $data['shop_list'] = $shop->getShopsListForPayment($user_login->user_id);
        $data['basic_plan'] = getBasicPlan($user->last_pay_date);
        if($user) {
            $data['user'] = $user;
        }
        $request->flash();
        $validate = $this->paymentConfirmValidator($request->all());
        if($validate->fails()) {
            return redirect()->route('user.postUserPayment')->with('errors', $validate->errors());
        }
        else {
            try {
                $creditCardCustomerId = '';
                $payment_amount = $request->payment_amount;
                $webpay = new WebPay(WEBPAY_PRIVATE_KEY);
                //Check user card info
                if(empty($user->credit_card_customer_id)) {
                    //Create new webpay customer
                    $customer = $webpay->customer->create(array("card"=>$request->token));
                    $creditCardCustomerId = $customer->id;
                }
                else {
                    //Update credit card info
                    $creditCardCustomerId = $user->credit_card_customer_id;
                    $result = $webpay->customer->update(array("id"=> $creditCardCustomerId,"card" => $request->token));
                }
                //Do payment
                $recursion_period = $data['basic_plan'][$request->basic_plan_id]['recursion_period'];
                $payment_period = $data['basic_plan'][$request->basic_plan_id]['period'];
                $result = $webpay->recursion->create(array(
                                                    "amount"   => $payment_amount,
                                                    "currency" => "jpy",
                                                    "customer" => $creditCardCustomerId,
                                                    "period"   => $recursion_period,
                                                ));
                if(empty($result->error)) {
                    $currentTime = \Carbon\Carbon::now();
                    //Update user info after payment success
                    $user->last_pay_date = $currentTime;
                    if(!empty($creditCardCustomerId)) {
                        $user->credit_card_customer_id = $creditCardCustomerId;
                    }
                    $user->credit_card_rec_id = $result->id;
                    $user->save();
                    foreach($data['shop_list'] as $shop) {
                        $shop->premium_flag = FMNET_SHOP_PREMIUM_FLG;
                        $shop->account_status = FMNET_SHOP_PAYMENT_FINISHED_CODE;
                        if(!empty($shop->premium_period) && $shop->premium_period > $currentTime) {
                            $shop->premium_period = date_add($shop->premium_period, date_interval_create_from_date_string($payment_period.' day'));
                        }
                        else {
                            $shop->premium_period = date_add($currentTime, date_interval_create_from_date_string($payment_period.' day'));
                        }
                        $shop->save();
                    }
                    $data['payment_result'] = $result;
                }
                else {
                    $data['error_message'] = $result->error->message;
                }
            } catch (\Exception $ex) {
                $data['error_message'] = $ex->getMessage();
                $template = 'user.payment_confirm';
            }
        }

        return view($template, $data);
    }

    public function resetPassword(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $data['title'] = trans('user.RESET_PASSWORD_TITLE');
        $template = 'user.reset_password';
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
    public function changePassword(Request $request)
    {
        $template = 'user.change_password';
        $errorHelper = new ErrorHelper;
        $data['title'] = trans('user.CHANGE_PASSWORD_TITLE');
        //Get parameters
        $uid  = isset($request->url)?$request->url:'';
        $email = isset($request->u)?$request->u:'';
        $data['email_en'] = $email;
        $data['uid_en'] = $uid;
        //Decrypt data
        try {
            $uid = Crypt::decrypt($uid);
            $email = Crypt::decrypt($email);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
            return view($template, $data);
        }
        //Check token data
        if(empty($uid) || empty($email)) {
            $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_MISSING_PARAMETER);
            return view($template, $data);
        }
        //Check registration data
        $user = User::where('email', $email)
                    ->where('user_id', $uid)
                    ->where('del_flg', 0)
                    ->first();
        if($user) {
            $data['email'] = $email;
            if($request->isMethod('get')) {//Return change password screen
                return view($template, $data);
            }
            else if($request->isMethod('post')) {// Do change password
                //Validates data
                $validate = $this->changePasswordValidator($request->all());
                if($validate->fails()) {
                    $data['errors'] = $validate->errors();
                    return view($template, $data);
                }
                else {
                    try {
                        $user->password = bcrypt($request->password);
                        $user->save();
                        $data['title'] = trans('user.CHANGE_PASSWORD_COMPLETE_TITLE');
                        return view('user.change_password_complete', $data);
                    } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                        $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                        return view($template, $data);
                    }
                }
            }
            else {//Return error
                $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_WRONG_TOKEN);
                return view($template, $data);
            }
        }
        else {
            $data['reset_errors'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_WRONG_TOKEN);
            return view($template, $data);
        }
    }
    /**
     * Get a validator for an incoming temp registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function tempRegistrationValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
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
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registrationValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:8|max:20|confirmed',
            'shop_id'  => 'required|alpha_num|min:6|max:14|unique:shop,shop_id',
            'shop_password' => 'required|min:8|max:20|confirmed',
            'user_name' => 'required',
            'shop_name' => 'required',
        ]);
    }
    /**
     * Get a validator for an incoming change password request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function changePasswordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:8|max:20|confirmed',
        ]);
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
            'company_name'  => 'max:255',
            'user_name' => 'required|max:255',
            'tel' => 'max:50',
        ]);
    }

    /**
     * Get a validator for an incoming edit payment info request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function paymentValidator(array $data)
    {
        return Validator::make($data, [
            'payer'      => 'max:255',
            'payer_kana' => 'max:255',
        ]);
    }

    /**
     * Get a validator for an incoming edit payment info request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function paymentConfirmValidator(array $data)
    {
        return Validator::make($data, [
            'payment_amount'=> 'required|numeric',
            'card_name'     => 'required',
            'card_company'  => 'required',
            'card_month'    => 'required|numeric',
            'card_year'     => 'required|numeric',
        ]);
    }

    protected function checkMailExists($email)
    {
        $user = new User;
        $tempRegistration = new TempRegistration;
        if($user->checkEmailExists($email) || $tempRegistration->checkEmailExists($email)) {
            return true;
        }
        else {
            return false;
        }
    }
}
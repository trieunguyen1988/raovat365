<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\User;
use App\TempRegistration;
use App\Shop;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $shop_id = $request->shop_id;
        $password = $request->password;
        $uuid = $request->uuid;
        /*Validate begin*/
        if(empty($shop_id) || empty($password) || empty($uuid)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        else {
            $shop = Shop::where('shop_id', $shop_id)->where('shop_password', $password)->where('account_status','<>',FMNET_SHOP_EXPIRED_CODE)->first();
            if(isset($shop->shop_id)) {
                //Create access token
                $access_token = getAccessToken(array($shop->shop_id, $uuid));
                $shop->access_token = Hash::make($access_token);
                $shop->save();
                $shop->access_token = $access_token;
                return responseApi($shop, FMNET_API_RETURN_CODE_SUCCESS);
            }
            else {
                return responseError(FMNET_ERROR_CODE_SHOP_NOT_EXISTS);
            }
        }
    }

    public function userRegister(Request $request)
    {
        $email = $request->email;
        $user = new User();
        /*Validate begin*/
        //If empty
        if(empty($email)){
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        //If wrong email
        $validator = Validator::make($request->all(), [
            'email' => 'email|max:255',
        ]);
        if ($validator->fails()) {
            if($validator->errors()->first('email')) {
                return responseError(FMNET_ERROR_CODE_WRONG_EMAIL);
            }
        }
        //If email exists
        if($user->checkEmailExists($email)) {
            return responseError(FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS);
        }
        /*Validate end*/

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
            return responseError(FMNET_ERROR_CODE_DATABASE_ERROR);
        }
        catch (\Swift_TransportException $e) {//Send mail error
            return responseError(FMNET_ERROR_CODE_SEND_MAIL_ERROR);
        }
        catch (\Exception $e) {// System error
            return responseError(FMNET_ERROR_CODE_SYSTEM_ERROR);
        }
        return responseApi($tempRegistration, FMNET_API_RETURN_CODE_SUCCESS, FMNET_MESSAGE_CREATE_USER_SUCCESS);
    }
}
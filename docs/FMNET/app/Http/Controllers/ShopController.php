<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\ErrorHelper;
use App\Shop;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $template = 'shop.list';
        $data['title'] = trans('shop.SHOP_LIST_TITLE');
        $shop = new Shop;
        $user = \Auth::user();
        $data['shops'] = $shop->getByUserId($user->user_id, FMNET_SHOP_ITEM_PER_PAGE);
        return view($template, $data);
    }

    public function create(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $template = 'shop.create';
        $data['title'] = trans('shop.SHOP_CREATE_TITLE');
        if($request->isMethod('post')) {
            //Validates data
            $request->flash();
            $user = \Auth::user();
            $validate = $this->registrationValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
            }
            else {
                //save shop
                $shop = new Shop();
                $shop->shop_id        = $request->shop_id;
                $shop->shop_password  = md5($request->shop_password);
                $shop->user_id        = $user->user_id;
                $shop->shop_name      = isset($request->shop_name)?$request->shop_name:'';
                $shop->account_status = FMNET_SHOP_TRIAL_CODE;
                $shop->register_date  = gmdate(DATE_TIME_FORMAT_DB);
                try {
                    $shop->save();
                    return redirect('shop');
                } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                    $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                } catch (\Exception $e) {
                    $data['error_message'] = $e->getMessage();
                }

            }
        }
        else {
            $request->flush();
        }

        return view($template, $data);
    }

    public function edit(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $template = 'shop.edit';
        $data['title'] = trans('shop.SHOP_EDIT_TITLE');
        $user = \Auth::user();
        $editing_shopid_en = !empty($request->shopid)?$request->shopid:'';
        //Decrypt data
        try {
            $editing_shopid = Crypt::decrypt($editing_shopid_en);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
            return redirect('shop');
        }
        $shop_model = new Shop;
        $shop = $shop_model->getById($editing_shopid, $user->user_id);
        if($shop) {
            $data['shop'] = $shop;
            $data['shopid'] = $editing_shopid_en;
            if($request->isMethod('post')) {
                //Validates data
                $request->flash();
                $validate = $this->editValidator($request->all());
                if($validate->fails()) {
                    $data['errors'] = $validate->errors();
                }
                else {
                    //save shop
                    if($request->shop_password != PASSWORD_MASK) {
                        $shop->shop_password  = md5($request->shop_password);
                    }
                    $shop->shop_name = isset($request->shop_name)?$request->shop_name:'';
                    try {
                        $shop->save();
                        $data['shopid'] = Crypt::encrypt($shop->shop_id);
                        $data['success_message'] = trans('shop.UPDATE_SUCCESS');
                    } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                        $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                    } catch (\Exception $e) {
                        $data['error_message'] = $e->getMessage();
                    }
                }
            }
            else {
                $request->flush();
            }
        }
        else {
            return redirect('shop');
        }

        return view($template, $data);
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
            'shop_id'  => 'required|alpha_num|min:6|max:14|unique:shop,shop_id',
            'shop_name' => 'required',
            'shop_password' => 'required|min:8|max:20|confirmed',
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
        $validate_array['shop_name'] = 'required';
        $validate_array['shop_password'] = 'required|min:8|max:20|confirmed';

        return Validator::make($data, $validate_array);
    }
}
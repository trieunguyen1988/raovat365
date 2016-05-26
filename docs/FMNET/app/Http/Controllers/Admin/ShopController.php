<?php
namespace App\Http\Controllers\Admin;
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
        $template = 'admin/shop.list';
        $data['title'] = trans('admin/shop.SHOP_LIST_TITLE');
        $request->flash();
        $data['params'] = $request->except(['page']);
        $shop = new Shop;
        $data['sort_list'] = getShopSortList();
        $sortInfo = (isset($request->sort_list) && isset($data['sort_list'][$request->sort_list]))?
                        $data['sort_list'][$request->sort_list]:$data['sort_list'][1];
        //Get shop list        
        $data['shops'] = $shop->getSearchList($request->all(), $sortInfo, FMNET_SHOP_ITEM_PER_PAGE);
        return view($template, $data);
    }

    public function edit(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $template = 'admin/shop.edit';
        $data['title'] = trans('admin/shop.SHOP_EDIT_TITLE');
        $editing_shopid_en = !empty($request->shopid)?$request->shopid:'';
        //Decrypt data
        try {
            $editing_shopid = Crypt::decrypt($editing_shopid_en);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('admin/shop');
        }
        $shop_model = new Shop;
        $shop = $shop_model->getByIdForAdmin($editing_shopid);
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
                        $data['success_message'] = trans('admin/shop.UPDATE_SUCCESS');
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
            return redirect('admin/shop');
        }

        return view($template, $data);
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
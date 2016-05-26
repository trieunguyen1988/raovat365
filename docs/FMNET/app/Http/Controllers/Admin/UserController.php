<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\User;
use App\TempRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ErrorHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = trans('admin/user.INDEX_PAGE');
        $template = 'admin.user.index';
        $data['params'] = $request->except(['page']);
        $data['sort_list'] = getUserSortList();
        $user = new User;
        $request->flash();
        $sortInfo = (isset($request->sort_list) && isset($data['sort_list'][$request->sort_list]))?
                        $data['sort_list'][$request->sort_list]:$data['sort_list'][1];
        $data['users'] = $user->getSearchList($request->all(), $sortInfo, FMNET_USER_PER_PAGE);
        $data['success_message'] = !empty($request->success_message)?$request->success_message:null;
        $data['error_message']   = !empty($request->error_message)?$request->error_message:null;
        return view($template, $data);

    }
    public function edit(Request $request)
    {
        $data['title'] = trans('admin/user.EDIT_PAGE');
        $errorHelper = new ErrorHelper;
        $template = 'admin.user.edit';

        $editingUserIdEncode = !empty($request->userid)?$request->userid:'';
        //Decrypt data
        try {
            $editingUserId = Crypt::decrypt($editingUserIdEncode);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('admin/user');
        }
        // Get user data from DB
        $userData = $data['user'] = User::find($editingUserId);
        if($userData) {
            $data['basic_plan'] = getBasicPlan($data['user']->last_pay_date);
            $data['userid'] = $editingUserIdEncode;
            $data['userid_de'] = $editingUserId;
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
                        //Save user data
                        if($request->email != $userData->email) {
                            if($this->checkMailExists($request->email)) {
                                $messageBag = new \Illuminate\Support\MessageBag();
                                $messageBag->add('email', $errorHelper->getErrorMessage(FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS));
                                $data['errors'] = $messageBag;
                                return view($template, $data);
                            }
                            else {
                                $userData->email = $request->email;
                            }
                        }
                        $userData->user_name = $request->user_name;
                        $userData->company_name = $request->company_name;
                        $userData->tel = $request->tel;
                        $userData->payer = $request->payer;
                        $userData->payer_kana = $request->payer_kana;
                        if(!empty($request->next_pay_date)) {
                            $formatNextPayDate = \DateTime::createFromFormat(DATE_FORMAT, $request->next_pay_date);
                            if($formatNextPayDate) {
                                $nextPayDate = $formatNextPayDate->format(DATE_FORMAT_DB);
                                $userData->next_pay_date = $nextPayDate;
                            }
                        }
                        $userData->next_pay_amount = $request->next_pay_amount;
                        $userData->basic_plan_id = $request->basic_plan_id;
                        $userData->memo = $request->memo;

                        try {
                            //Begin transaction save user data
                            DB::beginTransaction();
                            $userData->save();
                            //Commit DB
                            DB::commit();
                            $data['success_message'] = trans('admin/user.UPDATE_SUCCESS');
                        } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                            DB::rollback();
                            $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                            return view($template, $data);
                        }
                    return view($template, $data);
                }
            }
        }
        else {
            redirect('admin/user');
        }
    }
    public function delete(Request $request)
    {
        $data['title'] = trans('admin/user.INDEX_PAGE');
        $errorHelper = new ErrorHelper;
        $action = 'Admin\UserController@index';

        $editingUserIdEncode = !empty($request->userid)?$request->userid:'';
        //Decrypt data
        try {
            $editing_userid = Crypt::decrypt($editingUserIdEncode);
        } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->action($action, $data);
        }
        // Get user data from DB
        $user_data = User::find($editing_userid);
        $data['userid'] = $editingUserIdEncode;
        //Check if method is post
        if ($request->isMethod('post')) {
            $request->flash();
            if($user_data) {
                //Delete user
                $user_data->del_flg = 1;
                try {
                    //Begin transaction save user data
                    DB::beginTransaction();
                    //Get shop list
                    $shops = $user_data->shops;
                    if($shops) {
                        foreach ($shops as $item) {
                            $item->del_flg = 1;
                            // Delete shop
                            $item->save();
                        }
                    }
                    //Delete user
                    $user_data->save();
                    //Commit DB
                    DB::commit();
                    $data['success_message'] = trans('admin/user.DELETE_SUCCESS');
                } catch (\Illuminate\Database\QueryException $e) {//Catch DB error
                    DB::rollback();
                    $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
                    return redirect()->action($action, $data);
                }
            }
            else {
                $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_DATABASE_ERROR);
            }

            return redirect()->action($action, $data);

        }
    }

    public function download(Request $request)
    {
        $csvHeaderArr = [
//            'user_id' => trans('admin/user.CSV_USER_ID'),
            'email' => trans('admin/user.CSV_EMAIL'),
//            'password' => trans('admin/user.CSV_PASSWORD'),
            'company_name' => trans('admin/user.CSV_COMPANY_NAME'),
            'user_name' => trans('admin/user.CSV_USER_NAME'),
            'tel' => trans('admin/user.CSV_TEL'),
            'payer' => trans('admin/user.CSV_PAYER') ,
            'payer_kana' => trans('admin/user.CSV_PAYER_KANA'),
            'next_pay_date' => trans('admin/user.CSV_NEXT_PAY_DATE'),
//            'last_pay_date' => trans('admin/user.CSV_LAST_PAY_DATE'),
//            'next_pay_amount' => trans('admin/user.CSV_NEXT_PAY_AMOUNT'),
            'basic_plan_id' => trans('admin/user.CSV_BASIC_PLAN_ID') ,
//            'payment_method' => trans('admin/user.CSV_PAYMENT_METHOD') ,
            'register_date' => trans('admin/user.CSV_REGISTER_DATE') ,
//            'temp_email' => trans('admin/user.CSV_TEMP_EMAIL') ,
//            'temp_email_expired_at' => trans('admin/user.CSV_TEMP_EMAIL_EXPIRED_AT'),
//            'credit_card_customer_id' => trans('admin/user.CSV_CREDIT_CARD_CUSTOMER_ID') ,
//            'credit_card_rec_id' => trans('admin/user.CSV_CREDIT_CARD_REC_ID'),
//            'memo' => trans('admin/user.CSV_MEMO'),
//            'del_flg' => trans('admin/user.CSV_DEL_FLG'),
        ];
        $sortList = getUserSortList();
        $sortInfo = (isset($request->sort_list) && isset($sortList[$request->sort_list]))?
                        $sortList[$request->sort_list]:$sortList[1];
        $basic_plan = getBasicPlanCSV();
        //Get data
        $user = new User;
        $list = $user->getSearchListCSV($request->all(), $sortInfo, array_keys($csvHeaderArr));

        //Add headers for each column in the CSV download
        $csvHeaderText = array_values($csvHeaderArr);
        array_unshift($list, $csvHeaderText);

        //Write to temp file
        $tempPath = storage_path(). '/temp.csv';
        $FH = fopen($tempPath, 'c+');
        foreach ($list as $row) {
            if(isset($row['basic_plan_id'])) {
                $row['basic_plan_id'] = isset($basic_plan[$row['basic_plan_id']])?strval($basic_plan[$row['basic_plan_id']]['name']):'';
            }
            if(isset($row['next_pay_date'])) {
                $row['next_pay_date'] = !empty(strtotime($row['next_pay_date']))?date(DATE_FORMAT, strtotime($row['next_pay_date'])):'';
            }
            if(isset($row['register_date'])) {
                $row['register_date'] = !empty(strtotime($row['register_date']))?date(DATE_FORMAT, strtotime($row['register_date'])):'';
            }
            fputcsv($FH, $row);
        }
        fclose($FH);

        //Response file
        $headers = array(
              'Content-Type: text/csv',
            );
        return response()->download($tempPath, 'users_'.date('Ymd').'.csv', $headers)->deleteFileAfterSend(true);
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
            'company_name'  => 'max:255',
            'user_name' => 'required|max:255',
            'tel' => 'max:50',
            'payer'  => 'max:255',
            'payer_name'  => 'max:255',
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
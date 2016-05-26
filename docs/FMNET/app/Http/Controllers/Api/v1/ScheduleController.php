<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Schedule;
use App\BgmSchedule;
use App\TimedSchedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /*
     * Add schedule API
     * @param Request $request
     * @return response
     */
    public function scheduleAdd(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $item_data = $request->item_data;
        if(empty($shop_id) || empty($item_data) || empty($access_token)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        return $this->_progressData($access_token, $shop_id, $item_data);
    }
    /*
     * Update schedule API
     * @param Request $request
     * @return response
     */
    public function scheduleUpdate(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $p_data = $request->p_data;
        if(empty($shop_id) || empty($p_data) || empty($access_token)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        //Check shop data
        $shop = Shop::where('shop_id', $shop_id)
                    ->where('account_status','<>',FMNET_SHOP_EXPIRED_CODE)
                    ->first();
        if(isset($shop->shop_id)) {
            //Check access token
            if(Hash::check($access_token, $shop->access_token)) {
                $p_data = json_decode($p_data);
                $schedule_id = isset($p_data->schedule_id)?$p_data->schedule_id:'';
                //Get schedule data from API
                $schedule = Schedule::findOrNew($schedule_id);
                $schedule->shop_id = $shop_id;
                $schedule->schedule_id = $schedule_id;
                $schedule->display_name = isset($p_data->display_name)?$p_data->display_name:'';
                $schedule->open_time = isset($p_data->open_time)?$p_data->open_time:'';
                $schedule->close_time = isset($p_data->close_time)?$p_data->close_time:'';
                try {
                    if($schedule->save()) {
                        return responseApi($schedule, FMNET_API_RETURN_CODE_SUCCESS);
                    }
                }catch (\Illuminate\Database\QueryException $e) {
                    return responseError(FMNET_ERROR_CODE_DATABASE_ERROR);
                }
            }
            else {
                return responseError(FMNET_ERROR_CODE_WRONG_TOKEN);
            }
        }
        else {
            return responseError(FMNET_ERROR_CODE_SHOP_NOT_EXISTS);
        }
    }
    /*
     * Delete schedule API
     * @param Request $request
     * @return response
     */
    public function scheduleDelete(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $p_id = isset($request->schedule_id)?$request->schedule_id:'';
        if(empty($shop_id) || empty($p_id) || empty($access_token)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        //Check shop data
        $shop = Shop::where('shop_id', $shop_id)
                    ->where('account_status','<>',FMNET_SHOP_EXPIRED_CODE)
                    ->first();
        if(isset($shop->shop_id)) {
            //Check access token
            if(Hash::check($access_token, $shop->access_token)) {
                //Get playlist data from API
                $schedule = Schedule::find($p_id);
                if($schedule) {
                    $schedule->del_flg = 1;
                    try {
                        DB::beginTransaction();
                        if($schedule->save()) {
                            BgmSchedule::deleteBySchedule($p_id, $shop_id);
                            TimedSchedule::deleteBySchedule($p_id, $shop_id);
                            DB::commit();
                            return responseApi($schedule, FMNET_API_RETURN_CODE_SUCCESS);
                        }
                    }catch (\Illuminate\Database\QueryException $e) {
                        DB::rollback();
                        return responseError(FMNET_ERROR_CODE_DELETE_PLAYLIST_FAIL);
                    }
                }
                else {
                    return responseError(FMNET_ERROR_CODE_PLAYLIST_NOT_FOUND);
                }
            }
            else {
                return responseError(FMNET_ERROR_CODE_WRONG_TOKEN);
            }
        }
        else {
            return responseError(FMNET_ERROR_CODE_SHOP_NOT_EXISTS);
        }
    }
    /*
     * Progress schedule data
     * @param String $access_token
     * @param String $shop_id
     * @param json $schedule_data
     * @return response
     */
    private function _progressData($access_token, $shop_id, $schedule_data)
    {
        //Check shop data
        $shop = Shop::where('shop_id', $shop_id)
                    ->where('account_status','<>',FMNET_SHOP_EXPIRED_CODE)
                    ->first();
        if(isset($shop->shop_id)) {
            //Check access token
            if(Hash::check($access_token, $shop->access_token)) {
                $schedule_data = json_decode($schedule_data);
                $schedule_data->shop_id = $shop_id;
                //Save data
                return $this->_doSaveData($schedule_data);
            }
            else {
                return responseError(FMNET_ERROR_CODE_WRONG_TOKEN);
            }
        }
        else {
            return responseError(FMNET_ERROR_CODE_SHOP_NOT_EXISTS);
        }
    }
    /*
     * Save schedule data
     * @param json $item_data
     * @return response
     */
    private function _doSaveData($item_data)
    {
        //Get schedule data from API
        $schedule_id = isset($item_data->schedule_id)?$item_data->schedule_id:'';
        $schedule = Schedule::findOrNew($schedule_id);
        $schedule->shop_id = $item_data->shop_id;
        $schedule->schedule_id = isset($item_data->schedule_id)?$item_data->schedule_id:'';
        $schedule->display_name = isset($item_data->display_name)?$item_data->display_name:'';
        $schedule->open_time = isset($item_data->open_time)?$item_data->open_time:'';
        $schedule->close_time = isset($item_data->close_time)?$item_data->close_time:'';
        try {
            //Begin transaction
            DB::beginTransaction();
            if($schedule->save()) {
                //Bgm schedule
                BgmSchedule::deleteBySchedule($schedule_id, $item_data->shop_id);
                if(!empty($item_data->bgm_schedule)) {
                    foreach($item_data->bgm_schedule as $bgm) {
                        $bgm_data = BgmSchedule::findOrNew($bgm->bgm_schedule_id);
                        foreach(get_object_vars($bgm) as $key=>$value) {
                            $bgm_data->$key = $value;
                        }
                        $bgm_data->shop_id = $schedule->shop_id;
                        $schedule->bgmSchedules()->save($bgm_data);
                    }
                }
                //Timed schedule
                TimedSchedule::deleteBySchedule($schedule_id, $item_data->shop_id);
                if(!empty($item_data->timed_schedule)) {
                    foreach($item_data->timed_schedule as $timed) {
                        $timed_data = TimedSchedule::findOrNew($timed->timed_schedule_id);
                        foreach(get_object_vars($timed) as $key=>$value) {
                            $timed_data->$key = $value;
                        }
                        $timed_data->shop_id = $schedule->shop_id;
                        $schedule->bgmSchedules()->save($timed_data);
                    }
                }
                //Finish, commit transaction
                DB::commit();
                return responseApi($schedule, FMNET_API_RETURN_CODE_SUCCESS);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //Rollback transaction
            DB::rollBack();
            return responseError(FMNET_ERROR_CODE_DATABASE_ERROR);
        }
    }
}
<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Playlist;
use App\Bgm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    /*
     * Add playlist API
     * @param Request $request
     * @return response
     */
    public function playlistAdd(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $p_data = $request->item_data;
        if(empty($shop_id) || empty($p_data) || empty($access_token)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        //Progress data
        return $this->_progressData($access_token, $shop_id, $p_data);
    }
    /*
     * Update playlist API
     * @param Request $request
     * @return response
     */
    public function playlistUpdate(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $p_data = $request->item_data;
        if(empty($shop_id) || empty($p_data) || empty($access_token)) {
            return responseError(FMNET_ERROR_CODE_MISSING_PARAMETER);
        }
        //Progress data
        return $this->_progressData($access_token, $shop_id, $p_data);
    }
    /*
     * Delete playlist API
     * @param Request $request
     * @return response
     */
    public function playlistDelete(Request $request)
    {
        $shop_id = $request->shop_id;
        $access_token = $request->access_token;
        $p_id = isset($request->playlist_id)?$request->playlist_id:'';
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
                $playlist = Playlist::find($p_id);
                if($playlist) {
                    $playlist->del_flg = 1;
                    try {
                        //Begin transaction
                        DB::beginTransaction();
                        if($playlist->save()) {
                            BGM::deleteBgmByPlaylist($p_id, $shop_id);
                            DB::commit();
                            return responseApi($playlist, FMNET_API_RETURN_CODE_SUCCESS);
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
     * Progress playlist data
     * @param String $access_token
     * @param String $shop_id
     * @param json $playlist_data
     * @return response
     */
    private function _progressData($access_token, $shop_id, $playlist_data)
    {
        //Check shop data
        $shop = Shop::where('shop_id', $shop_id)
                    ->where('account_status','<>',FMNET_SHOP_EXPIRED_CODE)
                    ->first();
        if(isset($shop->shop_id)) {
            //Check access token
            if(Hash::check($access_token, $shop->access_token)) {
                //Save data
                $playlist_data = json_decode($playlist_data);
                $playlist_data->shop_id = $shop_id;
                return $this->_doSaveData($playlist_data);
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
     * Save playlist data
     * @param json $playlist_data
     * @return response
     */
    private function _doSaveData($playlist_data)
    {
        try {
            $playlist_id = isset($playlist_data->playlist_id)?$playlist_data->playlist_id:'';
            //Get playlist data from API
            $playlist = Playlist::firstOrNew(['playlist_id'=>$playlist_id, 'shop_id'=>$playlist_data->shop_id]);
            $playlist->playlist_id = $playlist_id;
            $playlist->shop_id = $playlist_data->shop_id;
            $playlist->playlist_name = isset($playlist_data->playlist_name)?$playlist_data->playlist_name:'';
            $playlist->playlist_total_time = isset($playlist_data->playlist_total_time)?$playlist_data->playlist_total_time:'';
            //Begin transaction
            DB::beginTransaction();
            if($playlist->save()) {
                BGM::deleteBgmByPlaylist($playlist_id, $playlist_data->shop_id);
                if(!empty($playlist_data->bgm)) {
                    foreach($playlist_data->bgm as $bgm) {
                        $bgm_data = BGM::firstOrNew(['bgm_id'=>$bgm->bgm_id, 'shop_id'=>$playlist_data->shop_id]);
                        foreach(get_object_vars($bgm) as $key=>$value) {
                            $bgm_data->$key = $value;
                        }
                        $bgm_data->shop_id = $playlist->shop_id;
                        $bgm_data->save();
                    }
                }
                //Finish, commit transaction
                DB::commit();
                return responseApi($playlist, FMNET_API_RETURN_CODE_SUCCESS);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //Rollback transaction
            DB::rollBack();
            return responseError(FMNET_ERROR_CODE_DATABASE_ERROR);
        }
    }
}
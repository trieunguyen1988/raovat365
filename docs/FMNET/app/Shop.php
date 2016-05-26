<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shop';
    protected $primaryKey = 'shop_id';
    public $incrementing = false;
    public $timestamps = false;
    /**
     * Get user
     * @return Object user
     */
    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }
    /**
     * Get playlists
     * @return Array playlists
     */
    public function playlists()
    {
        return $this->hasMany('App\Playlist', $this->primaryKey, $this->primaryKey);
    }
    /**
     * Get shop list
     * @param int $recordOfPage
     * @return Array shops
     */
    public function getList($recordOfPage = FMNET_SHOP_ITEM_PER_PAGE)
    {
        return $this->where('del_flg', 0)
                    ->paginate($recordOfPage);
    }    
    /**
     * Get shop by user Id
     * @param string $userId
     * @param int $recordOfPage
     * @return Array shops
     */
    public function getByUserId($userId, $recordOfPage = FMNET_SHOP_ITEM_PER_PAGE)
    {
        return $this->where('user_id', $userId)
                    ->where('del_flg', 0)
                    ->paginate($recordOfPage);
    }
    /**
     * Search shop list
     * @param Array $conditionArr
     * @param String $orderInfo
     * @param int $recordOfPage
     * @return array Shop
     */
    public function getSearchList($conditionArr, $orderInfo, $recordOfPage = FMNET_USER_PER_PAGE)
    {
        return $this->buildQuery($conditionArr, $orderInfo)
                    ->paginate($recordOfPage);
    }
    /**
     * Build query function
     * @param Array $conditionArr
     * @param String $orderInfo
     * @param int $recordOfPage
     * @return Query
     */
    private function buildQuery($conditionArr, $orderInfo)
    {
        return $this->where('del_flg', 0)
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['userid'])) {
                            $query->where('user_id', $conditionArr['userid']);
                        }
                    })                
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_shop_id'])) {
                            $query->where('shop_id', 'like', '%'.$conditionArr['search_shop_id'].'%');
                        }
                    })
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_shop_name'])) {
                            $query->where('shop_name', 'like', '%'.$conditionArr['search_shop_name'].'%');
                        }
                    })
                    ->where(function ($query) use ($conditionArr) {
                        $fromTrialPeriod = isset($conditionArr['search_from_trial_period'])?\DateTime::createFromFormat(DATE_FORMAT, $conditionArr['search_from_trial_period']):'';
                        $toTrialPeriod = isset($conditionArr['search_to_trial_period'])?\DateTime::createFromFormat(DATE_FORMAT, $conditionArr['search_to_trial_period']):'';
                        if($fromTrialPeriod && $toTrialPeriod) {
                            $query->whereBetween('trial_period', [$fromTrialPeriod->format(DATE_FORMAT_DB), $toTrialPeriod->format(DATE_FORMAT_DB)]);
                        }                                                
                        else if($fromTrialPeriod) {
                            $query->where('trial_period', '>=', $fromTrialPeriod->format(DATE_FORMAT_DB));
                        }
                        else if($toTrialPeriod) {
                            $query->where('trial_period', '<=', $toTrialPeriod->format(DATE_FORMAT_DB));
                        }                        
                    })
                    ->orderBy($orderInfo['field'], $orderInfo['order']);
    }    
    /**
     * Get shop by Id
     * @param int $shopId
     * @param string $userId
     * @return Object shop
     */
    public function getById($shopId, $userId)
    {
        return $this->where('shop_id', $shopId)
                    ->where('user_id', $userId)
                    ->where('del_flg', 0)
                    ->first();
    }
    /**
     * Get shop by Id for admin
     * @param int $shopId
     * @return Object shop
     */
    public function getByIdForAdmin($shopId)
    {
        return $this->where('shop_id', $shopId)
                    ->where('del_flg', 0)
                    ->first();
    }    
    /**
     * Get shop list for payment
     * @param string $userId
     * @return Array shop
     */
    public function getShopsListForPayment($userId) {
        return $this->where('user_id', $userId)
                    ->where('account_status', FMNET_SHOP_TRIAL_CODE)
                    ->where('del_flg', 0)
                    ->get();
    }
}
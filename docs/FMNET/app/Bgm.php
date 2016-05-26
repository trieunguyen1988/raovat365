<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bgm extends Model
{
    protected $table = 'bgm';
    protected $primaryKey = 'bgm_id';
    public $incrementing = false;
    public $timestamps = false;
    public static function deleteBgmByPlaylist($playlist_id, $shop_id) {
        $bgms = parent::where('shop_id', $shop_id)
                    ->where('playlist_id', $playlist_id)
                    ->get();
        if(!empty($bgms)) {
            foreach($bgms as $bgm) {
                $bgm->del_flg = 1;
                $bgm->save();
            }
        }        
    }
}
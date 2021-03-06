<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BgmSchedule extends Model
{
    protected $table = 'bgm_schedule';
    protected $primaryKey = 'bgm_schedule_id';
    public $incrementing = false;
    public $timestamps = false;
    public function schedule()
    {
        return $this->hasOne('App\Schedule', 'schedule_id', 'schedule_id');
    }
    public static function deleteBySchedule($schedule_id, $shop_id)
    {
        $items = parent::where('shop_id', $shop_id)
                    ->where('schedule_id', $schedule_id)
                    ->get();
        if(!empty($items)) {
            foreach($items as $item) {
                $item->del_flg = 1;
                $item->save();
            }
        }
    }
}

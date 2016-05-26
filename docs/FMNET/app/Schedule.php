<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'schedule_id';
    public $incrementing = false;
    public $timestamps = false;
    public function bgmSchedules()
    {
        return $this->hasMany('App\BgmSchedule', $this->primaryKey, $this->primaryKey);
    }
    public function timedSchedules()
    {
        return $this->hasMany('App\TimedSchedule', $this->primaryKey, $this->primaryKey);
    }
}
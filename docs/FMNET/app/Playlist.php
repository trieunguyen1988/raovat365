<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlist';
    protected $primaryKey = 'playlist_id';
    public $incrementing = false;    
    public $timestamps = false;
    public function bgms()
    {
        return $this->hasMany('App\Bgm', $this->primaryKey, $this->primaryKey);
    }
    public function shop()
    {
        return $this->hasOne('App\Shop', 'shop_id', 'shop_id');
    }
}

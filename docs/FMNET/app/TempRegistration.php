<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempRegistration extends Model
{
    protected $table = 'temp_registration';
    protected $primaryKey = 'temp_registration_id';
    public $timestamps = false;
    protected $fillable = ['email'];
    public function checkEmailExists($email)
    {
        return $this->where('email', $email)
                    ->where('used_flg', 0)
                    ->where('expired_at','>', \Carbon\Carbon::now()->toDateTimeString())
                    ->exists();
    }
}

<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'fullname', 'email', 'password', 'role_id'
    ];
}

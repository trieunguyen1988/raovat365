<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Authenticable as AuthenticableTrait;

class AdminUser extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    protected $table = 'admin_user';
    protected $primaryKey = 'email';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->email;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->email;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return '';
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        return;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }
}

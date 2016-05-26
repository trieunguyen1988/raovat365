<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Authenticable as AuthenticableTrait;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    public function shops()
    {
        return $this->hasMany('App\Shop', $this->primaryKey, $this->primaryKey);
    }
    /**
     * Check user exists by email
     * @param String $email
     * @return Boolean isExists
     */
    public function checkEmailExists($email)
    {
        return $this->where('email', $email)
                    ->orWhere(function ($query) use ($email){
                        $query->where('temp_email_expired_at','>', \Carbon\Carbon::now()->toDateTimeString())
                              ->where('temp_email', $email);
                    })
                    ->where('del_flg', 0)
                    ->exists();
    }
    /**
     * Get user by email
     * @param String $email
     * @return User user
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)
                    ->where('del_flg', 0)
                    ->first();
    }
    /**
     * Get user list
     * @param int $recordOfPage
     * @return User user
     */
    public function getList($recordOfPage = FMNET_USER_PER_PAGE)
    {
        return $this->where('del_flg', 0)
                    ->paginate($recordOfPage);
    }
    /**
     * Search user list for CSV
     * @param Array $conditionArr
     * @param String $orderInfo
     * @param int $recordOfPage
     * @return User user
     */
    public function getSearchListCSV($conditionArr, $orderInfo, $selectedColumns)
    {
        return $this->buildQuery($conditionArr, $orderInfo)
                    ->addSelect($selectedColumns)
                    ->get()
                    ->toArray();
    }
    /**
     * Search user list
     * @param Array $conditionArr
     * @param String $orderInfo
     * @param int $recordOfPage
     * @return User user
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
     * @return User user
     */
    private function buildQuery($conditionArr, $orderInfo)
    {
        return $this->where('del_flg', 0)
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_company_name'])) {
                            $query->where('company_name', 'like', '%'.$conditionArr['search_company_name'].'%');
                        }
                    })
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_user_name'])) {
                            $query->where('user_name', 'like', '%'.$conditionArr['search_user_name'].'%');
                        }
                    })
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_tel'])) {
                            $query->where('tel', 'like', '%'.$conditionArr['search_tel'].'%');
                        }
                    })
                    ->where(function ($query) use ($conditionArr) {
                        if(!empty($conditionArr['search_email'])) {
                            $query->where('email', 'like', '%'.$conditionArr['search_email'].'%');
                        }
                    })
                    ->orderBy($orderInfo['field'], $orderInfo['order']);
    }    
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->user_name;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->user_id;
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

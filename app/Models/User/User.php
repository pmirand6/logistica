<?php

namespace App\Models\User;

use App\Models\Admins\Admins;
use App\Models\Driver\Driver;
use App\Models\Order\Order;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model //implements AuthenticatableContract, AuthorizableContract
{
    //use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'userType',
        'email',
        'sub'
    ];

    protected $hidden = [
        'remember_token'
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'relUser', 'id');
    }

    public function driver()
    {
        return $this->hasOne(Driver::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admins::class, 'user_id');
    }

}

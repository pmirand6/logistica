<?php

namespace App\Models\Admins;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $fillable = ['active', 'user_id'];

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
}

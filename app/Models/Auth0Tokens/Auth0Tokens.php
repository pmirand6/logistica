<?php

namespace App\Models\Auth0Tokens;

use Illuminate\Database\Eloquent\Model;

class Auth0Tokens extends Model
{
    protected $fillable = [
        'client_id',
        'access_token'
    ];
}

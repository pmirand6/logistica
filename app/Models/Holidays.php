<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    protected $fillable = [
        'name',
        'date',
        'type'
    ];
}

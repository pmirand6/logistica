<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Alsofronie\Uuid\UuidModelTrait;

class Tracking extends Model
{
    use UuidModelTrait;

    protected $primaryKey = 'trackingId';
    protected $table = 'trackings';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $fillable = [
        'shippingId',
        'status',
        'email_action'
    ];
    public $incrementing = false;
}

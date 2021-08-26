<?php

namespace App\Models\PurchaseOrder;

use App\Models\Shipping\Shipping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    protected $fillable = [
      'code'
    ];

    public function shippings(): HasMany
    {
        return $this->hasMany(Shipping::class, 'purchase_order_id', 'id')->orderBy('estimatedDeliveryDate', 'asc');
    }
}

<?php


namespace App\Models\Shipping;

use Alsofronie\Uuid\UuidModelTrait;
use App\Events\ShippingUpdated;
use App\Helpers\UuidGenerator;
use App\Models\Driver\Driver;
use App\Models\Node\Node;
use App\Models\NodeVehicle;
use App\Models\Order\Order;
use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\Vehicle\Vehicle;
use App\State\ShippingStateManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @mixin Eloquent
 */
class Shipping extends Model
{
    use UuidModelTrait;

    public $primaryKey = 'shippingId';
    // protected $table = 'shippings';
    public $incrementing = false;
    protected $fillable = [
        'shippingId',
        'node_id',
        'providerAddress',
        'estimatedDeliveryDate',
        'status',
        'customerDeliveryAddress',
        'product',
        'product_price',
        'product_id',
        'quantity',
        'clientName',
        'client_email',
        'client_phone_number',
        'client_identification_number',
        'requiresCold',
        'deliveryType',
        'productImageUrl',
        'qrCode',
        'pickingOrderCode',
        'orderDate',
        'shippingCode',
        'providerEmail',
        'providerName',
        'statusCode',
        'purchase_order_id',
        'productDescription',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($shipping) {
            $shippingCode = new UuidGenerator();
            $shipping->shippingCode = $shippingCode(config('uuidCodes.SHIPPING_CODE.LENGTH'));
        });
    }

    public function pickOrder()
    {
        return $this->belongsTo(Order::class, 'pickingOrderCode', 'orderCode');
    }

    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id');
    }

    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function scopeWithNode($query, $nodeId)
    {
        return $query->where([
            ['node_id', '=', $nodeId],
            ['deliveryType', '<>', 'takeaway']
        ]);
    }

    public function scopeWithDeliveryOrder($query, $orderId = null)
    {
        return $query->where('pickingOrderCode', $orderId);
    }

    public function scopeWithAllDeliveryTypes($query)
    {
        return $query->whereIn('deliveryType', ['delivery', 'node', 'takeaway']);
    }

    public function scopeWithFirstState($query)
    {
        return $query->where([
            ['deliveryType', '=', 'node'],
            ['status', '=', config('DeliveryStates/node_states.NODE.PACKED.NAME')]
        ])->orWhere([
            ['deliveryType', '=', 'delivery'],
            ['status', '=', config('DeliveryStates/delivery_states.DELIVERY.PACKED.NAME')]
        ])->orWhere([
            ['deliveryType', '=', 'takeaway'],
            ['status', '<>', config('DeliveryStates/take_away_states.TAKEAWAY.PACKED.NAME')]
        ]);
    }

    public function scopeWithProviderFirstState($query)
    {
        return $query->where([
            ['deliveryType', '=', 'node'],
            ['status', '=', config('DeliveryStates/node_states.NODE.PRODUCT_ORDER_CONFIRMED.NAME')]
        ])->orWhere([
            ['deliveryType', '=', 'delivery'],
            ['status', '=', config('DeliveryStates/delivery_states.DELIVERY.PRODUCT_ORDER_CONFIRMED.NAME')]
        ])->orWhere([
            ['deliveryType', '=', 'takeaway'],
            ['status', '<>', config('DeliveryStates/take_away_states.TAKEAWAY.CLOSED.NAME')]
        ]);
    }

    public function scopeWithRequiresCold($query, $requiresCold)
    {
        return $query->where("requiresCold", $requiresCold);
    }

    public function scopeWithStatus($query, $statusCode)
    {
        return $query->where("statusCode", $statusCode);
    }

    public function scopeWithShippingCode($query, $shippingCode)
    {
        return $query->where("shippingCode", $shippingCode)
            ->orWhereHas('purchase_order', function ($q) use ($shippingCode) {
                $q->where('code', $shippingCode);
            });
    }


    public function scopeWithProviderEmail($query, $email)
    {
        return $query->where("providerEmail", $email);
    }

}

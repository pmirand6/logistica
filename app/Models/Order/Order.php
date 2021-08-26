<?php


namespace App\Models\Order;

use App\Helpers\UuidGenerator;
use App\Models\Driver\Driver;
use App\Models\RoadMap\RoadMap;
use App\Models\Shipping\Shipping;
use App\Models\User\User;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class Order extends Model
{
    use UuidModelTrait;

    protected $primaryKey = 'orderId';
    public $incrementing = false;

    protected $fillable = [
        'deliveryType', 'relShipping', 'relVehicle', 'relDriver', 'relUser', 'status', 'updated_at', 'statusCode'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $orderCode = new UuidGenerator();
            $order->orderCode = $orderCode(config('uuidCodes.ORDER_CODE.LENGTH'), config('uuidCodes.ORDER_CODE.PREFIX'));
        });
    }

    public function driver()
    {
        return $this->hasOne(Driver::class, 'driverId', 'relDriver');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'vehicleId', 'relVehicle');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'relUser');
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'shippingId', 'relShipping');
    }

    public function roadMap()
    {
        return $this->belongsTo(RoadMap::class, 'road_map_code', 'roadMapCode');
    }

}

<?php


namespace App\Models\Vehicle;

use App\Models\Driver\Driver;
use App\Models\Node\Node;
use App\Models\DeliveryType\DeliveryType;
use App\Models\Order\Order;
use App\Models\VehiclePicture\VehiclePicture;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use UuidModelTrait;
    use SoftDeletes;
    protected $guarded = [];
    protected $fillable = ['vehicleId', 'brand', 'model', 'licensePlate', 'year', 'vehiclePicture', 'workHourStart', 'workHourEnd', 'deliveryDays', 'extern', 'active'];
    protected $table = 'vehicle';
    public $primaryKey  = 'vehicleId';
    public $incrementing = false;
    //Tell laravel to fetch text values and set them as arrays
    protected $casts = [
        'deliveryDays' => 'array',
    ];
    public $path="/vehicle";


    public function driver()
    {
        return $this->belongsToMany(Driver::class, 'driverVehicle', 'relVehicleId', 'relDriverId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            })->withTimestamps();
    }

    public function node()
    {
        return $this->belongsToMany(Node::class, 'nodeVehicle', 'relVehicleId', 'relNodeId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            })->withTimestamps();
    }

    public function deliveryType()
    {
        return $this->belongsToMany(DeliveryType::class, 'deliveryTypeVehicle', 'relVehicleId', 'relDeliveryTypeId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            })->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class,
            'vehicleId',
            'relVehicle');
    }

    public function vehiclePicture()
    {
        return $this->hasMany(VehiclePicture::class, 'relVehicleId', 'vehicleId');
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%'.$value.'%');
    }


}

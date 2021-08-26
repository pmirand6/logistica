<?php

namespace App\Models\VehiclePicture;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;

class VehiclePicture extends Model
{
    use UuidModelTrait;

    public $primaryKey  = 'id';

    protected $table = 'vehiclePicture';

    protected $fillable = ['id', 'relVehicleId', 'vehiclePicture'];

    public $incrementing = false;

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'relVehicleId', 'vehicleId');
    }

}

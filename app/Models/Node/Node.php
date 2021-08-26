<?php


namespace App\Models\Node;

use App\Models\Driver\Driver;
use App\Models\DriverVehicle;
use App\Models\Shipping\Shipping;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Node extends Model
{
    use UuidModelTrait;
    use SoftDeletes;

    protected $fillable = [
        'nodeId',
        'name',
        'businessName',
        'workDays',
        'workHourStart',
        'workHourEnd',
        'geo',
        'latitude',
        'longitude',
        'streetName',
        'floor',
        'departmentNumber',
        'logo',
        'phoneNumber',
        'email',
        'active',
    ];
    // protected $table = 'nodes';
    public $primaryKey = 'nodeId';
    public $incrementing = false;
    //Tell laravel to fetch text values and set them as arrays
    protected $casts = [
        'workDays' => 'array',
    ];


    public function vehicle()
    {
        // La clase con la que me relaciono, la tabla pivot, la foreign key que me relaciona, la foreign key que me da acceso a la tabla que me quiero relacionar.
        return $this->belongsToMany(Vehicle::class, 'nodeVehicle', 'relNodeId', 'relVehicleId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            });
    }


    public function shipping()
    {
        return $this->hasMany(Shipping::class, 'node', 'nodeId');
    }

}

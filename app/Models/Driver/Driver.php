<?php


namespace App\Models\Driver;

use App\Models\Order\Order;
use App\Models\User\User;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Student
 * @package App
 * @mixin Builder
 */
class Driver extends Model
{
    use UuidModelTrait;
    use SoftDeletes;

    protected $primaryKey = 'driverId';
    protected $table = 'driver';
    public $incrementing = false;
    public $path = "/driver";

    protected $fillable = [
        'driverId',
        'identityDocument',
        'lastName',
        'name',
        'email',
        'areaCode',
        'phone',
        'driverPicture',
        'status',
        'postalCode',
        'address',
        'provinceId',
        'countryId',
        'active',
        'formatted_address',
    ];


    public function vehicle()
    {
        return $this->belongsToMany(Vehicle::class, 'driverVehicle', 'relDriverId', 'relVehicleId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            });

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class,
            'driverId',
            'relDriver');
    }

    public function scopeWithNames($query, $names)
    {
        return $query->where('name', 'LIKE', "%$names%")
            ->orWhere('lastName', 'LIKE', '%' . $names . '%')
            ->with('vehicle');
    }

    public function scopeWithDni($query, $driverDni)
    {
        return $query->where('identityDocument', 'LIKE', "%$driverDni%");
    }

    /**
     * Call as $driverObject->full_name
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->lastName}";
    }

}

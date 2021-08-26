<?php


namespace App\Models\DeliveryType;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryType extends Model
{
    use UuidModelTrait;
    use SoftDeletes;
    protected $fillable = ['deliveryTypeId'];
    protected $table = 'deliveryTypes';
    public $primaryKey  = 'deliveryTypeId';
    public $incrementing = false;



    public function vehicle()
    {
        // La clase con la que me relaciono, la tabla pivot, la foreign key que me relaciona, la foreign key que me da acceso a la tabla que me quiero relacionar.
        return $this->belongsToMany(Vehicle::class, 'deliveryTypeVehicle', 'relDeliveryTypeId', 'relVehicleId')
            ->using(new class extends Pivot {
                use UuidModelTrait;
            });
    }

}

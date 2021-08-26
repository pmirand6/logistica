<?php


namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class NodeVehicle extends Pivot
{
    use UuidModelTrait;
    use SoftDeletes;

    public $primaryKey  = 'id';

    protected $table = 'nodeVehicle';

}

<?php

namespace App\Models\RoadMap;

use Alsofronie\Uuid\UuidModelTrait;
use App\Helpers\UuidGenerator;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class RoadMap extends Model
{
    use UuidModelTrait;

    protected $primaryKey = 'road_map_id';
    public $incrementing = false;
    use UuidModelTrait;

    protected $fillable = [
        'rel_picking_order',
        'road_map_code',
        'rel_driver_id',
    ];

//    protected static function boot()
//    {
//        parent::boot();
//        static::creating(function ($hr) {
//            $road_map_code = new UuidGenerator();
//            $hr->road_map_code = $road_map_code(config('uuidCodes.ROAD_MAP_CODE.LENGTH'), config('uuidCodes.ROAD_MAP_CODE.PREFIX'));
//        });
//    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'orderId', 'rel_picking_order');
    }

    public function scopeWithCodeRoadMap()
    {
        $road_map_code = new UuidGenerator();
        return $road_map_code(config('uuidCodes.ROAD_MAP_CODE.LENGTH'), config('uuidCodes.ROAD_MAP_CODE.PREFIX'));
    }


}

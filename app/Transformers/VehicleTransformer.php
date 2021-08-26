<?php


namespace App\Transformers;


use App\Models\Vehicle\Vehicle;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class VehicleTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'driver'
    ];

    public function transform(Vehicle $vehicle)
    {
        return [
            'vehicleId' => (string)$vehicle->vehicleId,
            'brand' => (string)$vehicle->brand,
            'model' => (string)$vehicle->model,
            'licensePlate' => (string)$vehicle->licensePlate,
            'year' => (string)$vehicle->year,
            'vehiclePicture' => (string)$vehicle->vehiclePicture
        ];
    }

    public function transformCollection($vehicle){
        $collectionItems = new Collection($vehicle->items(), $this);
        return (new Manager)->createData($this->responsePaginate($collectionItems, $vehicle));
    }

    private function responsePaginate($collectionItems, $collection)
    {
        return $collectionItems->setPaginator(new IlluminatePaginatorAdapter($collection));
    }

    /**
     * Include Author
     *
     * @param Vehicle $vehicle
     * @return Item
     */
    public function includeAuthor(Vehicle $vehicle)
    {
        $drivers = $vehicle->driver;
        return $this->item($drivers, new DriverTransformer);
    }

}

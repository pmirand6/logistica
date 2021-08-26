<?php


namespace App\Transformers;

use App\Models\Driver\Driver;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class DriverTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'vehicle'
    ];

    public function transform(Driver $driver)
    {
        return [
            'driverId' => (string)$driver->driverId,
            'identityDocument' => (string)$driver->identityDocument,
            'lastName' => (string)$driver->lastName,
            'name' => (string)$driver->name,
            'email' => (string)$driver->email,
            'phone' => (string)$driver->phone,
            'driverPicture' => (string)$driver->driverPicture,
            'status' => (string)$driver->status,
            'postalCode' => (string)$driver->postalCode,
            'street' => (string)$driver->street,
            'streetNumber' => (string)$driver->streetNumber,
            'floorAddress' => (string)$driver->floorAddress,
            'locality' => (string)$driver->locality,
            'provinceId' => (int)$driver->provinceId,
            'countryId' => (int)$driver->countryId,
            'active' => (string)$driver->active,
        ];
    }

    public function transformCollection($driver){
        $collectionItems = new Collection($driver->items(), $this);
        return (new Manager)->createData($this->responsePaginate($collectionItems, $driver));
    }

    private function responsePaginate($collectionItems, $collection)
    {
        return $collectionItems->setPaginator(new IlluminatePaginatorAdapter($collection));
    }

    /**
     * Include Author
     *
     * @param Driver $driver
     * @return Item
     */
    public function includeAuthor(Driver $driver)
    {
        $vehicle = $driver->vehicle;
        return $this->item($vehicle, new VehicleTransformer);
    }

}

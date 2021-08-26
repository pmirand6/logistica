<?php


namespace App\Manager;


use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class ResponseManager extends Manager
{

    public static function responseCollection($collection, $transformer = null)
    {
        $collectionItems = new Collection($collection->items(), $transformer);
        return (new Manager)->createData(self::responsePaginate($collectionItems, $collection));
    }

    public static function responseItem($item, $transformer)
    {
        return (new Manager)->createData(new Fractal\Resource\Item($item, $transformer));
    }

    private static function responsePaginate($collectionItems, $collection)
    {
        return $collectionItems->setPaginator(new IlluminatePaginatorAdapter($collection));
    }

}

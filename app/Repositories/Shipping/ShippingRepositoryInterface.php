<?php


namespace App\Repositories\Shipping;


interface ShippingRepositoryInterface
{
    public function showAllShippings($request);

    public function showShippingByCode($shippingId);

    public function updateShipping($request, $shippingCode);

    public function createShipping($request);

    public function getShippingsByNode($nodeId);

    public function getStates($request);

    public function getShippingsByProviderEmail($request);

}

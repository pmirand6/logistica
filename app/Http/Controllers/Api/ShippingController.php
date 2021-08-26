<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Shipping\ShippingRepositoryInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ShippingController extends Controller
{

    /**
     * @var ShippingRepositoryInterface
     */
    private $shippingInterface;

    public function __construct(ShippingRepositoryInterface $shippingInterface)
    {
        $this->shippingInterface = $shippingInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        return $this->shippingInterface->showAllShippings($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        return $this->shippingInterface->createShipping($request);
    }

    /**
     * Display the specified resource.
     *
     * @param $shippingCode
     * @return void
     */
    public function show($shippingCode)
    {
        return $this->shippingInterface->showShippingByCode($shippingCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $shippingCode
     * @return void
     */
    public function update(Request $request, $shippingCode)
    {
        return $this->shippingInterface->updateShipping($request, $shippingCode);
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function getShippingsByNode($nodeId)
    {
        return $this->shippingInterface->getShippingsByNode($nodeId);
    }

    public function getStates(Request $request)
    {
        return $this->shippingInterface->getStates($request);
    }

    public function getShippingsByProviderEmail(Request $request)
    {
        return $this->shippingInterface->getShippingsByProviderEmail($request);
    }

}

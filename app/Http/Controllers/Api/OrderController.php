<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    private $orderInterface;

    public function __construct(OrderRepositoryInterface $orderInterface)
    {
        $this->orderInterface = $orderInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->orderInterface->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       /*$this->validate($request, [
           'shipping_id' => 'required',
           'vehicle_id' => 'required',
           'driver_id' => 'required',
           'user_id' => 'required'
       ]);*/
        return $this->orderInterface->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($orderCode)
    {
        return $this->orderInterface->show($orderCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderCode)
    {
        return $this->orderInterface->updateOrder($request, $orderCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOrdersByDriver($driverId, $date)
    {
        return $this->orderInterface->getOrdersByDriver($driverId, $date);
    }
}

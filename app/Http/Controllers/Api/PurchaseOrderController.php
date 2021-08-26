<?php

namespace App\Http\Controllers\Api;

use App\Models\PurchaseOrder\PurchaseOrder;
use App\Repositories\PurchaseOrder\PurchaseOrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{

    /**
     * @var PurchaseOrderRepositoryInterface
     */
    private $purchaseOrderInterface;

    public function __construct(PurchaseOrderRepositoryInterface $purchaseOrderInterface)
    {
        $this->purchaseOrderInterface = $purchaseOrderInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $purchaseOrderCode
     * @return \Illuminate\Http\Response
     */
    public function store($purchaseOrderCode)
    {
        return $this->purchaseOrderInterface->store($purchaseOrderCode);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}

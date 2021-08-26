<?php


namespace App\Repositories\PurchaseOrder;


use App\Models\PurchaseOrder\PurchaseOrder;
use Illuminate\Support\Facades\Log;

class PurchaseOrderRepository implements PurchaseOrderRepositoryInterface
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function show($purchaseOrder)
    {
        // TODO: Implement show() method.
    }

    public function store($purchaseOrderCode)
    {
        try{
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->code = $purchaseOrderCode;
            $purchaseOrder->save();

            return $purchaseOrder;
        } catch (\Exception $e) {
            Log::error(__class__ . ' Error en la Generación de PurchaseOrder: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}

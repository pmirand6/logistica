<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DeliveryType\DeliveryTypeRepositoryInterface;
use Illuminate\Http\Request;

class DeliveryTypeController extends Controller
{
    protected $deliveryTypeInterface;

    public function __construct(DeliveryTypeRepositoryInterface $deliveryTypeInterface)
    {
        $this->deliveryTypeInterface = $deliveryTypeInterface;
    }

    public function index()
    {
        return $this->deliveryTypeInterface->getAllDeliveryTypes();

    }

    public function DeliveryTypeVehicleDropRelation($deliveryTypeId, $vehicleId)
    {
        return $this->deliveryTypeInterface->DeliveryTypeVehicleDropRelation($deliveryTypeId, $vehicleId);
    }

}

<?php
/**
 * Class ShippingStateManager
 * @package App\State
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 6/12/20 01:36
 */

namespace App\State;

use App\Models\Shipping\Shipping;
use App\State\ContextStates\StatesFactory;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\This;

class ShippingStateManager
{
    protected $shippingActualState;

    public static function shippingState($deliveryType, $statusCode): string
    {

        $shippingStateObject = StatesFactory::create($statusCode);

        return $shippingStateObject->getStatusName($deliveryType, $statusCode);

    }

    public static function checkUpdateShipping($nextStatusCode, $currentStateCode, $deliveryType, $request): bool
    {
        $shippingStateObject = StatesFactory::create($currentStateCode);
        if(!$shippingStateObject){
            return false;
        }
        $resultPermissions = $shippingStateObject->canBeStateTransitioned($deliveryType, $currentStateCode, $nextStatusCode, $request);

        Log::info(json_encode([
            'class' => __CLASS__,
            'method' => __METHOD__,
            'canBeTransitionedByUser' => $resultPermissions
        ]));
        return $resultPermissions;
    }

    public static function getNextState($shippingStatusCode, $deliveryType, $request): array
    {
        try{
            $shippingStateObject = StatesFactory::create($shippingStatusCode);
            return $shippingStateObject->getNextState($shippingStatusCode, $deliveryType, $request);
        } catch (\Exception $e) {
            Log::error(json_encode([
                'error' => __METHOD__ . " Error en {$shippingStatusCode} - DeliveryType: {$deliveryType}",
                'message' => $e->getMessage(),
            ]));
        }

    }

}

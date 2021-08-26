<?php
/**
 * Class CreatedShippingState
 * @package App\State
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 6/12/20 01:14
 */

namespace App\State\ContextStates;

use App\Models\Shipping\Shipping;
use App\State\getStateByDeliveryType;
use App\State\ShippingState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PendingPaymentShippingState extends ShippingState
{


    /**
     * @return bool
     */
    public function mustTransitionStateToOrder(): bool
    {
        return false;
    }


    /**
     * @param $deliveryType
     * @param $statusCode
     * @return string
     * Retorna el nombre del estado
     */
    public function getStatusName($deliveryType, $statusCode): string
    {
        return $this->getStatusNameByDeliveryType($deliveryType, $statusCode);
    }

    /**
     * @return bool
     */
    public function mustTransitionToDeliveryOrder(): bool
    {
        return false;
    }

    /**
     * @param $shippingDeliveryType
     * @param $currentState
     * @param $nextStatusCode
     * @param Request $request
     * @return bool
     *
     * Verifica si el estado actual del shipping corresponde que pueda ser
     * transicionado al estado que se esta pasando por request
     */
    public function canBeTransitioned($shippingDeliveryType, $currentState, $nextStatusCode, Request $request): bool
    {
        return $this->canBeStateTransitioned($shippingDeliveryType, $currentState, $nextStatusCode, $request);
    }


    /**
     * @param $actualState
     * @param $deliveryType
     * @param Request $request
     * @return array Retorna el próximo estado
     *
     * Retorna el próximo estado
     */
    public function getNextState($actualState, $deliveryType, Request $request): array
    {
        return $this->getNextStatesByDeliveryType($deliveryType, $actualState, $request);
    }


}

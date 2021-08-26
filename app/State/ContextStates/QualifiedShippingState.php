<?php
/**
 * Class QualifiedShippingState
 * @package App\State
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 8/12/20 10:34
 */

namespace App\State\ContextStates;
use App\Models\Shipping\Shipping;
use App\State\ShippingState;
use Illuminate\Http\Request;

class QualifiedShippingState extends ShippingState
{

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
     * @inheritDoc
     */
    public function mustTransitionToDeliveryOrder(): bool
    {
        // TODO: Implement mustTransitionToDeliveryOrder() method.
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

<?php
/**
 * Class ShippingState
 * @package App\State
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 6/12/20 01:11
 */

namespace App\State;

use App\Models\Shipping\Shipping;
use Illuminate\Http\Request;

abstract class ShippingState
{

    use getNextStatesByDeliveryType, canBeTransitioned {
        canBeTransitioned::statePolicy insteadof getNextStatesByDeliveryType;
    }
    use getStatusNameByDeliveryType;

    /**
     * @param $deliveryType
     * @param $statusCode
     * @return string
     * Retorna el nombre del estado
     */
    abstract public function getStatusName($deliveryType, $statusCode): string;

    /**
     * @return bool
     * Indica si el estado en cuestión debe ser impactado en la tabla de
     * Delivery Order
     */
    abstract public function mustTransitionToDeliveryOrder(): bool;

    /**
     * @param $actualState
     * @param $deliveryType
     * @param Request $request
     * @return array Retorna el próximo estado
     *
     * Retorna el próximo estado
     */

    abstract public function getNextState($actualState, $deliveryType, Request $request): array;

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
    abstract public function canBeTransitioned($shippingDeliveryType, $currentState, $nextStatusCode, Request $request): bool;

}

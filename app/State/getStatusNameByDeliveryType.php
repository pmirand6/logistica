<?php


namespace App\State;


use Illuminate\Http\Request;

trait getStatusNameByDeliveryType
{

    public function getStatusNameByDeliveryType($shippingDeliveryType, $statusCode): string
    {
        $deliveryType = strtoupper($shippingDeliveryType);

        switch ($deliveryType) {
            case $deliveryType == 'NODE':
                return $this->getNameStatus($deliveryType, 'node_states', $statusCode);
                break;
            case $deliveryType == 'DELIVERY':
                return $this->getNameStatus($deliveryType, 'delivery_states', $statusCode);
                break;
            case $deliveryType == 'TAKEAWAY':
                return $this->getNameStatus($deliveryType, 'take_away_states', $statusCode);
                break;
        }
    }

    private function getNameStatus($deliveryType, $typeState, $statusCode): string
    {
        return config("DeliveryStates/{$typeState}.{$deliveryType}.{$statusCode}.NAME");
    }

}

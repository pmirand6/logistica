<?php


namespace App\State;


use Illuminate\Support\Facades\Log;

trait getNextStatesByDeliveryType
{
    use statePolicy;
    protected $configState;
    protected $request;

    public function getNextStatesByDeliveryType($shippingDeliveryType, $actualState, $request): array
    {
        $this->request = $request;
        $deliveryType = strtoupper($shippingDeliveryType);

        switch ($deliveryType) {
            case $deliveryType == 'NODE':
                $this->configState = $this->nodeStates($deliveryType, $actualState);
                break;
            case $deliveryType == 'DELIVERY':
                $this->configState = $this->deliveryStates($deliveryType, $actualState);
                break;
            case $deliveryType == 'TAKEAWAY':
                $this->configState = $this->takeAwayStates($deliveryType, $actualState);
                break;
        }
        return $this->configState;
    }

    private function nodeStates($deliveryType, $actualState): array
    {

        $nextStateCode = config("DeliveryStates/node_states.{$deliveryType}.{$actualState}.NEXT_STATE");
        return $this->createArrayOfNextCodes($nextStateCode, 'node_states', $deliveryType);

    }

    private function deliveryStates($deliveryType, $actualState): array
    {
        $nextStateCode = config("DeliveryStates/delivery_states.{$deliveryType}.{$actualState}.NEXT_STATE");
        return $this->createArrayOfNextCodes($nextStateCode, 'delivery_states', $deliveryType);
    }

    private function takeAwayStates($deliveryType, $actualState): array
    {
        $nextStateCode = config("DeliveryStates/take_away_states.{$deliveryType}.{$actualState}.NEXT_STATE");
        return $this->createArrayOfNextCodes($nextStateCode, 'take_away_states', $deliveryType);
    }

    private function createArrayOfNextCodes($nextStateCode, $typeState, $deliveryType): array
    {

        $arrayNextStatus = [];
        $arrayCode = [];
        foreach ($nextStateCode as $statusCode){
            $statePolicyResult = $this->statePolicy($typeState, $deliveryType, $statusCode, $this->request);

            if($statePolicyResult)
            {
                $nameNextState = config("DeliveryStates/{$typeState}.{$deliveryType}.{$statusCode}.NAME");
                $arrayCode = [
                    'CODE' => $statusCode,
                    'NAME' => $nameNextState
                ];
                array_push($arrayNextStatus, $arrayCode);
            }
        }

        return $arrayNextStatus;

    }
}

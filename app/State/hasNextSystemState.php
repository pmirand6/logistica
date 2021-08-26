<?php


namespace App\State;


use Illuminate\Support\Facades\Log;

trait hasNextSystemState
{
    protected $hasSystemState;
    protected $systemStateName;
    protected $systemStateCode;
    protected $request;

    public function getNextStatesByDeliveryType($shippingDeliveryType, $actualState): bool
    {
        $deliveryType = strtoupper($shippingDeliveryType);

        switch ($deliveryType) {
            case $deliveryType == 'NODE':
                $this->hasSystemState = $this->nodeStates($deliveryType, $actualState);
                break;
            case $deliveryType == 'DELIVERY':
                $this->hasSystemState = $this->deliveryStates($deliveryType, $actualState);
                break;
            case $deliveryType == 'TAKEAWAY':
                $this->hasSystemState = $this->takeAwayStates($deliveryType, $actualState);
                break;
        }
        return $this->hasSystemState;
    }

    private function nodeStates($deliveryType, $actualState): bool
    {

        $nextStateCode = config("DeliveryStates/node_states.{$deliveryType}.{$actualState}.NEXT_STATE");
        return $this->hasSystemNextCode($nextStateCode, 'node_states', $deliveryType);

    }

    private function deliveryStates($deliveryType, $actualState): bool
    {
        $nextStateCode = config("DeliveryStates/delivery_states.{$deliveryType}.{$actualState}.NEXT_STATE");
        return $this->hasSystemNextCode($nextStateCode, 'delivery_states', $deliveryType);
    }

    private function takeAwayStates($deliveryType, $actualState): bool
    {
        $nextStateCode = config("DeliveryStates/take_away_states.{$deliveryType}.{$actualState}.NEXT_STATE");

        return $this->hasSystemNextCode($nextStateCode, 'take_away_states', $deliveryType);
    }

    private function hasSystemNextCode($nextStateCode, $typeState, $deliveryType): bool
    {

        if(count($nextStateCode) !== 1){
            Log::info(json_encode([
                'countNextStates' => count($nextStateCode)
            ]));
            return false;
        }

        if($this->hasSystemRole($typeState, $deliveryType, $nextStateCode)){
            $this->systemStateName = config("DeliveryStates/{$typeState}.{$deliveryType}.{$nextStateCode[0]}.NAME");
            $this->systemStateCode = $nextStateCode[0];
            return true;
        }
        return false;

    }

    private function hasSystemRole($typeState, $deliveryType, $nextStateCode): bool
    {
        return in_array('System', config("DeliveryStates/{$typeState}.{$deliveryType}.{$nextStateCode[0]}.ROL"));
    }
}



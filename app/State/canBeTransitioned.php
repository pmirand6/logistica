<?php

namespace App\State;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait canBeTransitioned
{
    use statePolicy;

    protected $resultPolicyState;
    protected $request;

    public function canBeStateTransitioned($shippingDeliveryType, $currentState, $nextStatusCode, Request $request): bool
    {
        $this->request = $request;
        $deliveryType = strtoupper($shippingDeliveryType);

        switch ($deliveryType) {
            case $deliveryType == 'NODE':
                $this->resultPolicyState = $this->checkPermissions($currentState, $nextStatusCode, 'node_states', $deliveryType);
                break;
            case $deliveryType == 'DELIVERY':
                $this->resultPolicyState = $this->checkPermissions($currentState, $nextStatusCode, 'delivery_states', $deliveryType);
                break;
            case $deliveryType == 'TAKEAWAY':
                $this->resultPolicyState = $this->checkPermissions($currentState, $nextStatusCode, 'take_away_states', $deliveryType);
                break;
        }
        return $this->resultPolicyState;
    }

    private function checkPermissions($currentState, $nextStatusCode, $typeState, $deliveryType): bool
    {

        $nextStateCodes = config("DeliveryStates/{$typeState}.{$deliveryType}.{$currentState}.NEXT_STATE");
        $nextStateExist = in_array($nextStatusCode, $nextStateCodes);
        $resultStatePolicy = $this->statePolicy($typeState, $deliveryType, $nextStatusCode, $this->request);

        Log::info(json_encode([
            'nextcodes' => $nextStateCodes,
            'policy' =>$resultStatePolicy,
            'existe' => $nextStateExist
        ]));
        return $nextStateExist && $resultStatePolicy;
    }
}

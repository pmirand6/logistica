<?php


namespace App\State;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait statePolicy
{
    public function statePolicy($typeState, $deliveryType, $statusCode, Request $request): bool
    {

        //$permissions = $request->instance()->query('permissions');
        $permissions = $request->permissions;

        $roles = config("DeliveryStates/{$typeState}.{$deliveryType}.{$statusCode}.ROL");
        foreach ($roles as $role) {
            $rol = config("Auth0Roles.{$role}.rolAuth0");
            if(in_array($rol, $permissions)){
                return true;
            }
        }
        return false;
    }

}

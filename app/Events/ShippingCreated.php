<?php

namespace App\Events;

use App\Models\Shipping\Shipping;

class ShippingCreated extends Event
{
    /**
     * @var Shipping
     */
    public $shipping;
    public $request;

    /**
     * Create a new event instance.
     *
     * @param Shipping $shipping
     * @param $request
     */
    public function __construct(Shipping $shipping, $request)
    {
        $this->shipping = $shipping;
        $this->request = $request;
    }
}

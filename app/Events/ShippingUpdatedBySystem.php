<?php

namespace App\Events;

use App\Models\Shipping\Shipping;

class ShippingUpdatedBySystem extends Event
{
    /**
     * @var Shipping
     */
    public $shipping;

    /**
     * Create a new event instance.
     *
     * @param Shipping $shipping
     */
    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }
}

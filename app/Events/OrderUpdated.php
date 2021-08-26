<?php

namespace App\Events;

use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderUpdated extends Event
{
    /**
     * @var Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     */
    public function __construct($request, Order $order)
    {
        $this->order = $order;
    }
}

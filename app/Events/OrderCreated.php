<?php

namespace App\Events;

use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderCreated extends Event
{
    /**
     * @var Order
     */
    public $request;
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     */
    public function __construct($request, Order $order)
    {
        $this->request = $request;
        $this->order = $order;
    }
}

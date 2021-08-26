<?php

namespace App\Events;

use App\Models\Driver\Driver;

class DriverUpdated extends Event
{
    /**
     * @var Driver
     */
    public $driver;

    /**
     * Create a new event instance.
     *
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;

    }
}

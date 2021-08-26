<?php

namespace App\Listeners;

use App\Events\DriverCreated;
use App\Models\User\User;
use Illuminate\Support\Facades\Log;

class AddDriverAsUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DriverCreated  $event
     * @return void
     */
    public function handle(DriverCreated $event)
    {
        User::create([
            'email' => $event->driver->email,
            'userType' => 'Distribuidor',
            'name' => $event->driver->lastName . ' ' . $event->driver->name
        ]);
    }
}

<?php

namespace App\Listeners;

use App\Events\DriverUpdated;
use App\Models\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DisableDriverUser
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
     * @param  DriverUpdated  $event
     * @return void
     */
    public function handle(DriverUpdated $event)
    {
        try {
            User::where('email', $event->driver->email)
                ->update([
                    'active' => 0
                ]);
        } catch (ModelNotFoundException $e)       {
            Log::error('DisableDriverUser ' . $e->getMessage());
        } catch (\Exception $e){
            Log::error('DisableDriverUser ' . $e->getMessage());
        }
    }
}

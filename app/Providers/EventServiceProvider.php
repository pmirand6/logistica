<?php

namespace App\Providers;

use App\Events\DriverCreated;
use App\Events\DriverUpdated;
use App\Events\ShippingCreated;
use App\Events\ShippingUpdated;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Events\RoadmapCreated;
use App\Events\ShippingUpdatedBySystem;
use App\Listeners\AddDriverAsUser;
use App\Listeners\AddTracking;
use App\Listeners\AddTrackingSystem;
use App\Listeners\AddTrackingUpdated;
use App\Listeners\CreateRoadMapWhenOrderIsCreated;
use App\Listeners\DisableDriverUser;
use App\Listeners\ChangeShippingStatus;
use App\Listeners\ChangeShippingStatusWhenCreatingOrder;
use App\Listeners\NextSystemState;
use App\Listeners\OrderChangeStatus;
use App\Listeners\ChangeOrderRoadmapCodeWhenCreatingRoadmap;
use App\Listeners\OrderChangeStatusSystem;
use App\Listeners\SendUpdatedStateSystemToStore;
use App\Listeners\SendUpdatedStateToStore;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DriverUpdated::class => [
            DisableDriverUser::class
        ],
        ShippingCreated::class => [
            AddTracking::class
        ],
        ShippingUpdated::class => [
            AddTrackingUpdated::class,
            OrderChangeStatus::class,
            SendUpdatedStateToStore::class,
            NextSystemState::class,
        ],
        ShippingUpdatedBySystem::class => [
            AddTrackingSystem::class,
            OrderChangeStatusSystem::class,
            SendUpdatedStateSystemToStore::class,
        ],
        OrderCreated::class => [
            ChangeShippingStatusWhenCreatingOrder::class
        ],
        OrderUpdated::class => [
            ChangeShippingStatus::class
        ],
        RoadmapCreated::class => [
            ChangeOrderRoadmapCodeWhenCreatingRoadmap::class
        ]
    ];
}

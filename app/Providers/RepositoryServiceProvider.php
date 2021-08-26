<?php


namespace App\Providers;


use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Auth0\Auth0Repository;
use App\Repositories\Auth0\Auth0RepositoryInterface;
use App\Repositories\Holidays\HolidaysRepository;
use App\Repositories\Holidays\HolidaysRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\PurchaseOrder\PurchaseOrderRepository;
use App\Repositories\PurchaseOrder\PurchaseOrderRepositoryInterface;
use App\Repositories\RoadMap\RoadMapInterface;
use App\Repositories\RoadMap\RoadMapRepository;
use App\Repositories\Shipping\ShippingRepositoryInterface;
use App\Repositories\Shipping\ShippingRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.
        $this->app->bind(
            'App\Repositories\Driver\DriverRepositoryInterface',
            'App\Repositories\Driver\DriverRepository'
        );
        $this->app->bind(
            'App\Repositories\Vehicle\VehicleRepositoryInterface',
            'App\Repositories\Vehicle\VehicleRepository'
        );

        $this->app->bind(
            'App\Repositories\Node\NodeRepositoryInterface',
            'App\Repositories\Node\NodeRepository'
        );
        $this->app->bind(
            'App\Repositories\DeliveryType\DeliveryTypeRepositoryInterface',
            'App\Repositories\DeliveryType\DeliveryTypeRepository'
        );
        $this->app->bind(ShippingRepositoryInterface::class, ShippingRepository::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        $this->app->bind(RoadMapInterface::class, RoadMapRepository::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(Auth0RepositoryInterface::class, Auth0Repository::class);

        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

        $this->app->bind(PurchaseOrderRepositoryInterface::class, PurchaseOrderRepository::class);

        $this->app->bind(HolidaysRepositoryInterface::class, HolidaysRepository::class);


    }

}

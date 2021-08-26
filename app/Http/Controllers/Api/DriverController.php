<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver\Driver;
use App\Repositories\Driver\DriverRepositoryInterface;
use Illuminate\Http\Request;


class DriverController extends Controller
{
    protected $driverInterface;

    public function __construct(DriverRepositoryInterface $driverInterface)
    {
        $this->driverInterface = $driverInterface;
    }

    public function index()
    {
        return $this->driverInterface->getAllActiveDrivers();
    }

    public function show($driverId)
    {
        return $this->driverInterface->getDriverById($driverId);
    }

    public function showDriverByName($name)
    {
        return $this->driverInterface->getDriverByName($name);
    }

    public function createDriver(Request $request)
    {
        //TODO CREAR VALIDACION
        return $this->driverInterface->createDriver($request);
    }

    public function updateDriver(Request $request, $driverId)
    {
        //TODO CREAR VALIDACION
        return $this->driverInterface->updateDriver($request, $driverId);
    }

    public function getDriverByDni($driverDni)
    {
        //TODO CREAR VALIDACION
        return $this->driverInterface->getDriverByDni($driverDni);
    }

    public function showVehiclesOfDriver($driverId)
    {
        return $this->driverInterface->showVehiclesOfDriver($driverId);
    }

    public function deleteDriver($driverId)
    {
        return $this->driverInterface->deleteDriver($driverId);
    }


}

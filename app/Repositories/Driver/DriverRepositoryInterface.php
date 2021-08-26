<?php


namespace App\Repositories\Driver;


interface DriverRepositoryInterface
{
    public function getAllActiveDrivers();

    public function getDriverById($driverId);

    public function getDriverByName($name);

    public function deleteDriver($driverId);

    public function updateDriver($request, $driverId);

    public function createDriver($request);

    public function getDriverByDni($driverDni);

    public function showVehiclesOfDriver($driverId);

}

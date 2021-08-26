<?php


namespace App\Repositories\Driver;

use App\Events\DriverCreated;
use App\Events\DriverUpdated;
use App\Manager\ImageManager;
use App\Manager\ResponseManager;
use App\Models\Driver\Driver;
use App\Models\User\User;
use App\Repositories\User\UserRepository;
use App\Resources\Driver\DriverCollection;
use App\Resources\Driver\DriverResource;
use App\Resources\DriverVehicle\DriverVehicleResource;

class DriverRepository extends ResponseManager implements DriverRepositoryInterface
{

    public function getAllActiveDrivers()
    {
        try {
            //TODO CREAR VALIDACIONES Y VERIFICAR QUE SEAN LOS DRIVERS ACTIVOS
            return DriverCollection::collection(Driver::paginate(6));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDriverById($id)
    {
        try {
            //TODO CREAR VALIDACIONES
            $driver = Driver::findOrFail($id);
            //if driver exists : tirar error
            return new DriverResource($driver);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDriverByName($name)
    {
        //TODO CREAR VALIDACIONES
        $drivers = Driver::withNames($name)->paginate(5);
        return DriverResource::collection($drivers);
    }

    public function deleteDriver($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update([
            'active' => 0
        ]);
        event(new DriverUpdated($driver));

        return new DriverResource($driver);
    }

    public function updateDriver($request, $driverId)
    {
        try {

            $driver = Driver::findOrFail($driverId);

            $driver->identityDocument = $request->dni;
            $driver->lastName = $request->last_name;
            $driver->name = $request->first_name;
            $driver->email = $request->e_mail;
            $driver->areaCode = $request->area_code;
            $driver->phone = $request->phone_number;
            $driver->status = $request->status;
            $driver->postalCode = $request->postal_code;
            $driver->address = $request->address;
            $driver->active = $request->active;
            $driver->formatted_address = $request->formatted_address;

            if ($request->has('driver_picture')) {
                $fileName = ImageManager::uploadBase64Image($request->driver_picture, $driver->path);
                $driver->driverPicture = $fileName;
            }

            $driver->save();

            if ($request->active === 0) {
                event(new DriverUpdated($driver));
            }

            return new DriverResource($driver);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function createDriver($request)
    {
        try {
            if (User::where('email', '=' ,$request->e_mail)->exists()) {
                return response()->json([
                    'error' => true,
                    'message' => "Correo en uso."
                ]);
            }

            if (Driver::where('identityDocument', '=' ,$request->dni)->exists()) {
                return response()->json([
                    'error' => true,
                    'message' => "DNI en uso."
                ]);
            }

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->e_mail,
                'userType' => 'Distribuidor',
                'active' => 1
            ]);

            $driver = new Driver;
            $driver->identityDocument = $request->dni;
            $driver->lastName = $request->last_name;
            $driver->name = $request->first_name;
            $driver->email = $request->e_mail;
            $driver->areaCode = $request->area_code;
            $driver->phone = $request->phone_number;
            $driver->status = 1;
            $driver->postalCode = $request->postal_code;
            $driver->address = $request->address;
            $driver->provinceId = $request->provinceId;
            $driver->countryId = $request->countryId;
            $driver->active = $request->active;
            $driver->user_id = $user->id;
            $driver->formatted_address = $request->formatted_address;

            if ($request->has('driver_picture')) {
                $fileName = ImageManager::uploadBase64Image($request->driver_picture, $driver->path);
                $driver->driverPicture = $fileName;
            }

            $driver->save();

            $user->driver()->save($driver);

            return new DriverResource($driver);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getDriverByDni($driverDni)
    {
        try {
            //TODO CREAR VALIDACIONES
            $drivers = Driver::withDni($driverDni)->paginate(3);
            return DriverResource::collection($drivers);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function showVehiclesOfDriver($driverId)
    {
        try {
            $driver = Driver::findOrFail($driverId);
            return new DriverVehicleResource($driver);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'nodes'], function () use ($router) {
        $router->get('/getNearest/', 'NodeController@getNearest');
    });

    $router->group(['prefix' => 'holidays'], function () use ($router) {
        $router->get('/', 'HolidaysController@index');
    })
    
    ;$router->group(['prefix' => 'pdf'], function() use ($router){
        $router->get('/', 'PdfController@index');
    });
});

//Rutas Autenticadas por el middleware de auth0
$router->group(['prefix' => 'api', 'namespace' => 'Api', 'middleware' => 'auth0'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/info', ['middleware' => ['user'], 'uses' => 'UserController@show']);
    });

    $router->group(['prefix' => 'admins'], function () use ($router){
       $router->get('/', 'AdminsController@index');
        $router->post('/', 'AdminsController@store');
    });

    $router->group(['prefix' => 'drivers'], function () use ($router) {
        $router->get('/{driverId}', 'DriverController@show');
        $router->get('/', 'DriverController@index');
        $router->get('dni/{driverDni}', 'DriverController@getDriverByDni');
        $router->post('/', 'DriverController@createDriver');
        $router->put('/{driverId}', 'DriverController@updateDriver');
        $router->get('showDriver/{name}', 'DriverController@showDriverByName');
        $router->get('/{driverId}/vehicle', 'DriverController@showVehiclesOfDriver');
        $router->delete('/{driverId}', 'DriverController@deleteDriver');
    });

    $router->group(['prefix' => 'vehicles'], function () use ($router) {
        $router->get('/{vehicleId}', 'VehicleController@show');
        $router->get('/', 'VehicleController@index');
        $router->get('/{vehicleId}/driver', 'VehicleController@showDriverOfVehicle');
        $router->get('/license/{vehicleLicense}', 'VehicleController@getVehicleByLicensePlate');
        $router->post('/{vehicleId}', 'VehicleController@createRelationsOfVehicle');
        $router->post('/', 'VehicleController@createVehicle');
        $router->put('/{vehicleId}', 'VehicleController@updateVehicle');
        //Endpoints de Vehicles + Nodes
        $router->get('/{vehicleId}/nodes', 'VehicleController@showNodesOfVehicle');
        $router->post('/{vehicleId}/nodes/{nodeId}', 'VehicleController@VehicleNodeCreateRelation');
        $router->delete('/{vehicleId}/nodes/{nodeId}', 'VehicleController@VehicleNodeDropRelation');
        //Endpoints de Vehicles + Drivers
        $router->post('/{vehicleId}/driver/{driverId}', 'VehicleController@VehicleDriverCreateRelation');
        $router->delete('/{vehicleId}/driver/{driverId}', 'VehicleController@VehicleDriverDropRelation');
        //Endpoints de Vehicle Images
        $router->delete('/{vehicleId}/picture/{vehiclePictureId}', 'VehicleController@DropVehiclePicture');
    });

    $router->group(['prefix' => 'deliveryTypes'], function () use ($router) {
        $router->get('/', 'DeliveryTypeController@index');
        $router->delete('/{deliveryTypeId}/vehicle/{vehicleId}', 'DeliveryTypeController@DeliveryTypeVehicleDropRelation');
    });

    $router->group(['prefix' => 'nodes'], function () use ($router) {
        $router->get('/{nodeId}', 'NodeController@show');
        $router->get('/', 'NodeController@index');
        $router->post('/', 'NodeController@createNode');
        $router->get('/{nodeId}/deliveryType/{deliveryType}', 'NodeController@getDistributorsFromNode');
        $router->put('/{nodeId}', 'NodeController@updateNode');
    });

    $router->group(['prefix' => 'shippings'], function () use ($router) {
        $router->get('/states', 'ShippingController@getStates');

        //packing list
        $router->get('/provider', ['middleware' => ['provider'], 'uses' => 'ShippingController@getShippingsByProviderEmail']);

        $router->get('/{shippingCode}', 'ShippingController@show');
        $router->post('/', 'ShippingController@store');
        $router->get('/', ['middleware' => ['admin'], 'uses' => 'ShippingController@index']);
        $router->get('/node/{nodeId}', 'ShippingController@getShippingsByNode');

        $router->put('/{shippingCode}', 'ShippingController@update');
    });

    $router->group(['prefix' => 'deliveryOrders'], function () use ($router) {
        $router->get('/{orderCode}', 'OrderController@show');
        $router->get('/', 'OrderController@index');
        $router->get('/driver/{driverId}/date/{date}', ['middleware' => 'driver', 'uses' => 'OrderController@getOrdersByDriver']);
        $router->post('/', 'OrderController@store');
        $router->put('/{orderCode}', 'OrderController@update');
    });

    $router->group(['prefix' => 'route-orders'], function () use ($router) {
        $router->get('/{orderCode}', 'RoadMapController@show');
        $router->get('/', 'RoadMapController@index');
        $router->get('/{orderCode}/driver/{driverId}', 'RoadMapController@getByDriver');
        $router->post('/', 'RoadMapController@store');
        $router->put('/{orderCode}', 'RoadMapController@update');
    });

    $router->group(['prefix' => 'label'], function () use ($router) {
        $router->get('/', 'LabelController@index');
    });

});

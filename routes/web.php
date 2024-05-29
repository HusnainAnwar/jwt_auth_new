<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api', 'middleware' => ('json')], function () use ($router) {
$router->post('register', ['uses' => 'AuthController@register']);
    $router->post('login', ['uses' => 'AuthController@login']);
    $router->get('servicesavailable', 'ServiceController@availableServices');

    
    // Vendor Routes
    $router->get('showallshops', 'VendorController@index');
    $router->post('addnewshop', 'VendorController@store');
    $router->post('showspecificshop/{id}', 'VendorController@show');
    $router->put('updateashop/{id}', 'VendorController@update');
    $router->delete('deleteAshop/{id}', 'VendorController@destroy');
    // Shop routes
    $router->group([ 'middleware' => 'shop'], function () use ($router) {
        //checking
    $router->get('showallservices', 'ServiceController@index');
    $router->post('addnewservices', 'ServiceController@store');
    $router->get('showall', 'ServiceController@show');
    $router->put('UpdateAservice/{id}', 'ServiceController@update');
    $router->delete('DeleteAservice/{id}', 'ServiceController@destroy');
    $router->get('shops/{shopId}', 'ServiceController@servicesByShop');

    // TimeSlot Routes
    $router->get('showalltimeslots', 'TimeSlotController@index');
    $router->post('Addtimeslot', 'TimeSlotController@store');
    $router->post('showtimeslotByShop/{id}', 'TimeSlotController@show');
    $router->put('UpdateTimeSlot/{id}', 'TimeSlotController@update');
    $router->delete('shops/{shop_id}/timeslots/{time_slot_id}', 'TimeSlotController@destroy');

    });
    // Customer routes
    $router->group([ 'middleware' => 'customer'], function () use ($router) {
        $router->post('book', 'AppointmentController@bookAppointment');
        $router->get('my', 'AppointmentController@myAppointments');
    });
    // protected routes
    $router->group([ 'middleware' => 'auth'], function () use ($router) {
        $router->post('logout', ['uses' => 'AuthController@logout']);
    });
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });
});



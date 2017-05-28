<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'adminapi'], function()
{
    Route::resource('room_type', 'RoomTypeController');
    Route::post('setpriceinrange', 'RoomCalendarController@setPriceInRangeForRoomType');
});

/** php artisan route:list

+--------+----------+-------------------------------------+----------------------------+-------------------------------------------------+------------+
| Domain | Method   | URI                                 | Name                       | Action                                          | Middleware |
+--------+----------+-------------------------------------+----------------------------+-------------------------------------------------+------------+
|        | GET|HEAD | /                                   |                            | Closure                                         |            |
|        | GET|HEAD | adminapi/room_type                  | adminapi.room_type.index   | App\Http\Controllers\RoomTypeController@index   |            |
|        | POST     | adminapi/room_type                  | adminapi.room_type.store   | App\Http\Controllers\RoomTypeController@store   |            |
|        | GET|HEAD | adminapi/room_type/create           | adminapi.room_type.create  | App\Http\Controllers\RoomTypeController@create  |            |
|        | DELETE   | adminapi/room_type/{room_type}      | adminapi.room_type.destroy | App\Http\Controllers\RoomTypeController@destroy |            |
|        | PATCH    | adminapi/room_type/{room_type}      |                            | App\Http\Controllers\RoomTypeController@update  |            |
|        | GET|HEAD | adminapi/room_type/{room_type}      | adminapi.room_type.show    | App\Http\Controllers\RoomTypeController@show    |            |
|        | PUT      | adminapi/room_type/{room_type}      | adminapi.room_type.update  | App\Http\Controllers\RoomTypeController@update  |            |
|        | GET|HEAD | adminapi/room_type/{room_type}/edit | adminapi.room_type.edit    | App\Http\Controllers\RoomTypeController@edit    |            |
+--------+----------+-------------------------------------+----------------------------+-------------------------------------------------+------------+
 */

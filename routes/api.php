<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(
    [
        'prefix'                          => '{version}',
        'namespace'                       => 'Api',
        Controller::ACTION_GROUP_NAME_KEY => Controller::ACTION_GROUP_NAME_PUBLIC_API,
    ],
    function () {
        Route::post('dialplan', 'DialplanController@store');
    }
);

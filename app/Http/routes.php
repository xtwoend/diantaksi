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

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//after login routes
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'DashboardController@index');
    Route::get('/home', 'DashboardController@index');
    Route::get('change/{pool_id}', 'DashboardController@change');

    Route::group(['prefix' => 'reports'], function () {

        // report gudang
        Route::get('armada/pemakaian.xls', 'WirehouseController@reportPemakaianDownload');
        Route::post('armada/pemakaian.json', 'WirehouseController@reportPemakaian');
        Route::get('armada/pemakaian', 'WirehouseController@viewPemakaian');

        Route::get('daily', 'ReportController@daily');
        Route::post('daily.json', 'ReportController@dailyjson');
        Route::get('daily.xlsx', 'ReportController@dailyexport');
        Route::post('dailysum.json', 'ReportController@dailysum');

        Route::get('range', 'ReportController@range');
        Route::post('range.json', 'ReportController@rangejson');
        Route::get('range.xlsx', 'ReportController@rangexport');
        Route::post('rangesum.json', 'ReportController@rangesum');

        Route::get('armada', 'ArmadaController@armada');
        Route::post('armada/reports.json', 'ArmadaController@reportjson');
        Route::get('armada/reports.xlsx', 'ArmadaController@export');
        Route::post('armada/hutang', 'ArmadaController@hutang');
        Route::get('armada/{id}', 'ArmadaController@index');

        Route::get('drivers/activity', 'DriverController@activity');
    });

    Route::group(['prefix' => 'statistics'], function () {
        Route::post('pendapatan', 'DashboardController@persentasePendapatan');
    });

    Route::resource('financials', 'FinancialController');

    Route::group(['prefix' => 'gudang'], function () {
        Route::resource('penerimaan', 'PSController');
        Route::post('penerimaan/item/update', ['uses' => 'PSController@itemUpdate', 'as' => 'gudang.penerimaan.item.update']);
    });
});

Route::get('/check', function () {

    $checkin = App\Diantaksi\Eloquent\Checkin::with('financial', 'fleet', 'driver', 'financial.label', 'document', 'physic', 'status')->take(10)->get();

    return $checkin;

});

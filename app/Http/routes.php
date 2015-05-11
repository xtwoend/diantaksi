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
Route::group(['middleware' => ['auth']], function(){
	
	Route::get('/', 'DashboardController@index');
	Route::get('/home', 'DashboardController@index');
	Route::get('change/{pool_id}', 'DashboardController@change');

	Route::group(['prefix'=>'reports'], function(){
		Route::get('daily', 'ReportController@daily');
		Route::post('daily.json', 'ReportController@dailyjson');
		Route::get('daily.xlsx', 'ReportController@dailyexport');
		Route::post('dailysum.json', 'ReportController@dailysum');

		Route::get('range', 'ReportController@range');
		Route::post('range.json', 'ReportController@rangejson');
		Route::get('range.xlsx', 'ReportController@rangexport');
		Route::post('rangesum.json', 'ReportController@rangesum');

		Route::get('armada', 'ArmadaController@armada');
		Route::get('armada/{id}', 'ArmadaController@index');
		Route::post('armada/hutang', 'ArmadaController@hutang');
	});

});


Route::get('/check', function () {
    
	$checkin = App\Diantaksi\Eloquent\Checkin::with('financial','fleet','driver','financial.label','document','physic', 'status')->take(10)->get();
    
    return $checkin;

});

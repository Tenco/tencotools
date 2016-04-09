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

Route::get('login', 'AuthController@login');
Route::get('oauthcallback', 'AuthController@handleProviderCallback');
Route::get('sociallogin', 'AuthController@redirectToProvider');
Route::get('logout', 'AuthController@logout');




Route::group(['Middleware' => ['web', 'auth']], function () /* middleware group defined in Kernel.php */
{
	//
		
	Route::get('/', 'ProjectsController@home');
	Route::get('project/create', 'ProjectsController@create');
	Route::post('project/store', 'ProjectsController@store');


	Route::get('project/{project}', 'ProjectsController@show');
	Route::patch('project/{project}', 'ProjectsController@update');
	Route::post('project/{project}/tasks', 'TasksController@store');
	Route::post('project/{project}/store/image', 'ProjectsController@storeImage');
	
	Route::get('task/{task}/edit', 'TasksController@edit');
	Route::POST('task/{task}/update', 'TasksController@update');
	Route::get('task/{task}/delete', 'TasksController@remove');
	Route::POST('ajax/tasks/{task}', 'TasksController@updateStage');

});

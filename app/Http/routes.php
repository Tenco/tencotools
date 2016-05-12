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
Route::get('logout', 'AuthController@logout');

/*
Route::get('mail', function(){

	return view('emails.newTask'); 

});
*/


Route::group(['Middleware' => ['web', 'auth']], function () /* middleware group defined in Kernel.php */
{
	// just to check paths on DigitalOcean
	/*
	Route::get('info', function (){

		return phpinfo();

	});
	*/
	/******* PROJECTS ********/
	// socialite needs to be inside web middleware
	Route::get('oauthcallback', 'AuthController@handleProviderCallback');
	Route::get('sociallogin', 'AuthController@redirectToProvider');

	Route::get('/', 'ProjectsController@home');
	Route::get('projects', 'ProjectsController@home');
	Route::get('project', 'ProjectsController@home');
	Route::get('project/create', 'ProjectsController@create');
	Route::post('project/store', 'ProjectsController@store');
	Route::get('project/{project}', 'ProjectsController@show');
	Route::get('project/{project}/edit', 'ProjectsController@edit');
	Route::get('project/image/{project}', 'ProjectsController@uploadImage');
	Route::patch('project/{id}/update', 'ProjectsController@update');
	Route::post('project/{project}/tasks', 'TasksController@store');
	Route::post('project/{project}/store/image', 'ProjectsController@storeImage');
	Route::get('project/{project}/files', 'ProjectsController@files');
	Route::get('project/{project}/kickstart', 'TasksController@kickstart');

	Route::get('project/{id}/revive', 'ProjectsController@revive');
	Route::get('project/{project}/archive', 'ProjectsController@archive');
	
	Route::get('removeblock/{project}/{task}', 'TasksController@removeblock');
	Route::get('removedeadline/{project}/{task}', 'TasksController@removedeadline');
	
	/******* TASKS ********/
	Route::get('task/{task}/edit', 'TasksController@edit');
	Route::patch('task/{task}/update', 'TasksController@update');
	Route::get('task/{task}/delete', 'TasksController@remove');
	Route::get('task/{task}/undo', 'TasksController@restore');
	Route::POST('tasks/{task}/stage', 'TasksController@updateStage');

	Route::post('project/{project}/store/file', 'ProjectFilesController@storeFile');
	Route::get('download/{file}', 'ProjectFilesController@download');
	Route::get('file/{file}/delete', 'ProjectFilesController@remove');

	/******* RELATIONS ********/
	Route::get('relations', 'RelationsController@home');
	Route::get('relations/create', 'RelationsController@create');
	Route::post('relations/store', 'RelationsController@store');
	Route::get('relations/image/{relation}', 'RelationsController@uploadImage');
	Route::post('relation/{relation}/store/image', 'RelationsController@storeImage');
	Route::get('relation/{relation}', 'RelationsController@show');
	Route::get('relations/{relation}/edit', 'RelationsController@edit');
	Route::patch('relations/{relation}/update', 'RelationsController@update');
	Route::post('relations/search', 'RelationsController@search');
	Route::get('relations/{relation}/delete', 'RelationsController@remove');
	Route::get('relations/{relation}/undo', 'RelationsController@restore');
	
});

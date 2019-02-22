`<?php



/****************** HOME CONTROLLER - mainly imports data from old system ******************/
Route::get('/', 'HomeController@index');
Route::get('/transfer', 'HomeController@view_old_data');
Route::post('/transfer', 'HomeController@get_data');

/*********** JOBS CONTROLLER - main controller ***************/
Route::get('/jobs', 'JobsController@index');
Route::post('/jobs', 'JobsController@index');
Route::get('/jobs/create/', 'JobsController@create');

//Route::view('/job/{$id}', 'jobs.show');
// Route::get('/job/{$id}', 'function e(){ echo "<h3>something</h3>"; exit; }');
Route::get('/jobs/show/{$id}', 'JobsController@show');
Route::get('/jobs/edit/{$id}', 'JobsController@edit');

Route::patch('/job/edit/{$id}', 'JobsController@update');


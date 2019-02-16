`<?php



/****************** HOME CONTROLLER - mainly imports data from old system ******************/
Route::get('/', 'HomeController@index');
Route::get('/transfer', 'HomeController@view_old_data');
Route::post('/transfer', 'HomeController@get_data');

/*********** JOBS CONTROLLER - main controller ***************/
Route::get('/job/show_all/', 'JobsController@index');
Route::get('/job/create/', 'JobsController@create');

//Route::view('/job/{$id}', 'jobs.show');
// Route::get('/job/{$id}', 'function e(){ echo "<h3>something</h3>"; exit; }');
Route::get('/job/{$job_info_id}', 'JobsController@show');
Route::get('/job/edit/{$id}', 'JobsController@edit');

Route::patch('/job/edit/{$id}', 'JobsController@update');


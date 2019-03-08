`<?php



/*********** JOBS CONTROLLER - main controller ***************/
Route::get('/', 'JobsController@index');
Route::post('/', 'JobsController@index');
Route::get('/create/', 'JobsController@create');
Route::post('/create/', 'JobsController@store');
Route::patch('/create/', 'JobsController@store');
Route::post('/view/{id}', 'JobsController@view');
/*** EDIT JOBS ***/
Route::post('/edit/{id}', 'JobsController@edit');
Route::patch('/edit/{id}', 'JobsController@update');
Route::delete('/edit/{id}', 'JobsController@delete_image');




Route::get('/jobs', 'JobsController@index');
Route::post('/jobs', 'JobsController@index');

//Route::view('/job/{$id}', 'jobs.show');
// Route::get('/job/{$id}', 'function e(){ echo "<h3>something</h3>"; exit; }');
Route::get('/jobs/show/{$id}', 'JobsController@show');


//NOT USED
/****************** HOME CONTROLLER - mainly imports data from old system ******************/
Route::get('/transfer', 'HomeController@view_old_data');
Route::post('/transfer', 'HomeController@get_data');




Route::patch('/job/edit/{$id}', 'JobsController@update');


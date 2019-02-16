`<?php



Route::get('/', 'HomeController@index');
Route::get('/transfer', 'HomeController@view_old_data');
Route::post('/transfer', 'HomeController@get_data');

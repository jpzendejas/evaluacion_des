<?php


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Specialty
//Pre Register Users
Route::get('/specialties','SpecialtyController@index');
Route::get('/specialties/create','SpecialtyController@create');//form registro
Route::get('/specialties/{specialty}/edit','SpecialtyController@edit');
Route::post('/specialties','SpecialtyController@store');//envio del form
Route::get('/specialties','SpecialtyController@index');

Route::middleware(['auth','admin'])->namespace('Admin')->group(function(){
Route::get('/get_pre_users','ValidateUsersController@get_pre_user');
Route::get('/approve_users/{pre_user}/approve','ValidateUsersController@approve_user');
Route::delete('/delete_pre_users/{id}','ValidateUsersController@delete_pre_user');
});

Route::get('/user_registers','PreRegisterUsersController@user_register')->name('user_register');
Route::get('/get_cities','PreRegisterUsersController@get_city');
Route::get('/get_suburbs','PreRegisterUsersController@get_suburb');
Route::post('/save_pre_registers','PreRegisterUsersController@save_pre_register');
Route::get('/mail','HomeController@email')->name('sendEmail');

Route::get('/evaluacion_desempeño','PerfomanceIndicatorsController@index');
Route::get('/employees_evaluation','PerfomanceIndicatorsController@employees_evaluations');
Route::get('/evaluacion/{token}','PerfomanceIndicatorsController@evaluaciones');
Route::post('/guardar_resultados','PerfomanceIndicatorsController@save_results');
Route::get('/preguntas','QuestionController@index');

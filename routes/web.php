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
//Questions Crud
Route::get('/preguntas','QuestionController@index');
Route::post('/obtener_preguntas','QuestionController@get_questions');
Route::post('/save_question','QuestionController@save_questions');
Route::post('/update_question/{id}','QuestionController@update_questions');

//Answers Crud
Route::get('/respuestas','AnswerController@index');
Route::post('/obtener_respuestas','AnswerController@get_answers');
Route::post('/save_answer','AnswerController@save_answers');
Route::post('/update_answer/{id}','AnswerController@update_answers');

//GovernmentAgency Crud
Route::get('/dependencias', 'GovernmentAgencyController@index');
Route::post('/get_governmentagency', 'GovernmentAgencyController@get_governmentagencies');
Route::post('/save_governmentagency','GovernmentAgencyController@save_governmentagencies');
Route::post('/update_governmentagency/{id}','GovernmentAgencyController@update_governmentagencies');

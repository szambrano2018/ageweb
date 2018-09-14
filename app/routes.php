<?php

Route::get('/', function()
{
	//return View::make('ageweb/login');
});
//**********************************DECLARAR CONTROLADORES********************************************
//***PARA DECLARAR TODAS RUTAS***
//Route::controller('/ageweb', "agewebController");


//**********************************DECLARAR RUTA POR RUTA********************************************
Route::get('inicio/{id}','agewebController@get_primerpaso');
Route::get('agendamiento','agewebController@get_agendamiento');
Route::post('horarios','agewebController@post_ajaxhorarios');
Route::post('especialidad','agewebController@post_ajaxmedicos');
Route::post('disponibilidad','agewebController@post_ajaxdisponibilidad');
Route::post('especialidadagenda','agewebController@post_ajaxmedicosagenda');
Route::get('agendamientoagenda','agewebController@get_agendamientoagenda');
Route::get('login','agewebController@get_login');
Route::get('registrarse','agewebController@get_registrar_usuario');
Route::post('reserva','agewebController@post_guardarregistroreserva');
Route::post('verificalogin','agewebController@post_postlogin');
Route::post('verificaloginagenda','agewebController@post_login2');
Route::post('segundoverificalogin','agewebController@post_postlogin2');
Route::get('segundoregistrarse','agewebController@get_registrar_usuario2');
Route::get('segundologin','agewebController@get_login2');
Route::post('segundareserva','agewebController@post_segundoguardarregistroreserva');
Route::get('email','agewebController@get_recuperaclave');
Route::post('verificaemail','agewebController@post_ajaxvalidacorreos');

//**********************************RUTAS DEL CONTROLADOR MENSAJERIA*********************************
Route::get('contrasena','mensajeriaController@get_olvidocontrasena');
Route::get('respuesta/{idreserva}/{md5}','mensajeriaController@get_updateconfirmar');
Route::get('segundarespuesta/{idreserva}/{md5}','mensajeriaController@get_updaterechazar');





<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/root', 'AppRoot@index')->name('appRoot');
Route::get('user/{id}', 'PatientController@showPatient');
Route::get('/patients', 'PatientController@showPatients')->name('patients');
Route::get('/vysetreni', 'ExamController@showExams')->name('exams');


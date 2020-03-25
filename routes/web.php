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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/{id}', 'PacientController@showPacient');
Route::get('/pacients', 'PacientController@showPacients')->name('pacients');


Route::get('/root', 'AppRoot@index')->name('appRoot');
Route::get('/patients', 'PatientController@showPatients')->name('patients');

Route::get('/exams', 'ExamController@showExams')->name('exams');
Route::get('/drugs', 'DrugController@showDrugs')->name('drugs');
Route::get('/sections', 'SectionController@showSections')->name('sections');
Route::get('/users', 'UserController@showUsers')->name('users');
Route::get('/interventions', 'InterventionController@showInterventions')->name('interventions');
Route::get('/hospitalizations', 'HospitalizationController@showHospitalizations')->name('hositalizations');

// CRUD routes :)

Route::post('/patients/add', 'PatientController@addPatients');
Route::post('/patients/del', 'PatientController@deletePatient');
Route::post('/patients/edit', 'PatientController@editPatient');
Route::get('/patients/get', 'PatientController@getPatients');
Route::post('/sections/add', 'SectionController@addSection');

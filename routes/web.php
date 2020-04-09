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
Route::get('/patients/{id?}', 'PatientController@showPatients')->name('patients');

Route::get('/exams', 'ExamController@showExams')->name('exams');
Route::get('/drugs', 'DrugController@showDrugs')->name('drugs');
Route::get('/sections', 'SectionController@showSections')->name('sections');
Route::get('/servings', 'ServingController@showServings')->name('servings');
//Route::get('/users', 'UserController@showUsers')->name('users');
Route::get('/interventions', 'InterventionController@showInterventions')->name('interventions');
Route::get('/hospitalizations', 'HospitalizationController@showHospitalizations')->name('hositalizations');

Route::get('/users', 'AdminController@users')
    ->middleware('is_admin')
    ->name('admin');
// CRUD routes :)

//Patient
Route::post('/patients/add', 'PatientController@addPatients');
Route::post('/patients/del', 'PatientController@deletePatient');
Route::post('/patients/edit', 'PatientController@editPatient');
Route::get('/pat/get', 'PatientController@getPatients');
Route::post('/sections/add', 'SectionController@addSection');

//Drugs
Route::post('/drugs/add', 'DrugController@addDrug');
Route::post('/drugs/del', 'DrugController@deleteDrug');
Route::post('/drugs/edit', 'DrugController@editDrug');
Route::get('/drugs/getAll', 'DrugController@getDrugs');

//Servings
Route::post('/servings/add', 'ServingController@addServing');
Route::post('/servings/del', 'ServingController@deleteServing');
Route::post('/servings/edit', 'ServingController@editServing');
Route::get('/servings/getAll', 'ServingController@getServings');

//Nurse
Route::get('/nurse/getAll', 'NurseController@getNurses');

// VIEW routes

// Patient
Route::post('/patient/getInfo', 'PatientController@getPatientInfo');
Route::post('/doctor/setPatient', 'DoctorController@setPatient');

// Serving
Route::post('/serving/getInfo', 'ServingController@getServingInfo');
Route::post('/serving/setNurse', 'ServingController@setNurse');
Route::post('/serving/setPatient', 'ServingController@setPatient');
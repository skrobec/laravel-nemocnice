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
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/root', 'AppRoot@index')->name('appRoot');
Route::get('/patients/{id?}', 'PatientController@showPatients')->name('patients');

Route::get('/exams', 'ExamController@showExams')->name('exams');
Route::get('/drugs', 'DrugController@showDrugs')->name('drugs');
Route::get('/sections', 'SectionController@showSections')->name('sections');
Route::get('/servings', 'ServingController@showServings')->name('servings');
Route::get('/hospitalizations', 'ServingController@showHospitalizations')->name('hospitalizations');
//Route::get('/users', 'UserController@showUsers')->name('users');
Route::get('/interventions', 'InterventionController@showInterventions')->name('interventions');
Route::get('/hospitalizations', 'HospitalizationController@showHospitalizations')->name('hospitalizations');

Route::get('/users', 'AdminController@users')->name('admin');
//Route::get('/users', 'AdminController@users')->middleware('is_admin')->name('admin');
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

//Sections
Route::post('/sections/add', 'SectionController@addSection');
Route::post('/sections/del', 'SectionController@deleteSection');
Route::post('/sections/edit', 'SectionController@editSection');
Route::get('/sections/getAll', 'SectionController@getSections');

//Servings
Route::post('/servings/add', 'ServingController@addServing');
Route::post('/servings/del', 'ServingController@deleteServing');
Route::post('/servings/edit', 'ServingController@editServing');
Route::get('/servings/getAll', 'ServingController@getServings');


//Interventions
Route::post('/interventions/add', 'InterventionController@addIntervention');
Route::post('/interventions/del', 'InterventionController@deleteIntervention');
Route::post('/interventions/edit', 'InterventionController@editIntervention');
Route::get('/interventions/getAll', 'InterventionController@getInterventions');

//Exams
Route::post('/exams/add', 'ExamController@addExam');
Route::post('/exams/del', 'ExamController@deleteExam');
Route::post('/exams/edit', 'ExamController@editExam');
Route::get('/exams/getAll', 'ExamController@getExams');


//Nurse
Route::get('/nurse/getAll', 'NurseController@getNurses');


// Hospitalizations
Route::post('/hospitalizations/add', 'HospitalizationController@addHospitalization');
Route::post('/hospitalizations/del', 'HospitalizationController@deleteHospitalization');
Route::post('/hospitalizations/edit', 'HospitalizationController@editHospitalization');
Route::post('/hospitalizations/end', 'HospitalizationController@endHospitalization');
Route::get('/hospitalizations/getAll', 'HospitalizationController@getHospitalizations');

// User
Route::get('/user/getAll', 'UserController@getUsers');
Route::post('/user/addJob', 'UserController@addJob');
Route::post('/user/getInfo', 'UserController@getInfo');
// VIEW routes

// Patient
Route::post('/patient/getInfo', 'PatientController@getPatientInfo');
Route::post('/doctor/setPatient', 'DoctorController@setPatient');

// Serving
Route::post('/serving/getInfo', 'ServingController@getServingInfo');
Route::post('/serving/setNurse', 'ServingController@setNurse');
Route::post('/serving/setPatient', 'ServingController@setPatient');
Route::get('/servingDetail', 'ServingController@showServingDetail');

// Intervention
Route::get('/interventionDetail', 'InterventionController@showInterventionDetail');
Route::post('/intervention/getInfo', 'InterventionController@getInterventionInfo');

//Hospitalization
Route::get('/hospitalizationDetail', 'HospitalizationController@showHospitalizationDetail');
Route::post('/hospitalization/getInfo', 'HospitalizationController@getHospitalizationInfo');

// USER routes
Route::get('/user/getNurses', 'UserController@getNurseUsers');
Route::get('/user/getDoctors', 'UserController@getDoctorUsers');
Route::get('/user/isAdmin', 'UserController@isAdmin');
Route::get('/users/userDetail', 'UserController@showUserDetail');


// EXam
Route::get('/examDetail', 'ExamController@showExamDetail');
Route::post('/exam/getInfo', 'ExamController@getExamInfo');

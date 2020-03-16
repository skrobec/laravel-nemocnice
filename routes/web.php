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

Route::get('/root', 'AppRoot@index')->name('appRoot');
Route::get('user/{id}', 'PatientController@showPatient');
Route::get('/patients', 'PatientController@showPatients')->name('patients');
Route::get('/vysetreni', 'ExamController@showExams')->name('exams');
Route::get('/leky', 'DrugController@showDrugs')->name('drugs');
Route::get('/oddeleni', 'SectionController@showSections')->name('sections');

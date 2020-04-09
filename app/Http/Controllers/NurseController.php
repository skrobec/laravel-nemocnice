<?php


namespace App\Http\Controllers;


use App\Nurse;
use App\Exam;
use App\Hospitalization;
use App\Intervention;
use App\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NurseController extends Controller {

    public function getNurses() {
        return (Nurse::all());
    }

   
}
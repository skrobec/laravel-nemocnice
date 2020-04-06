<?php


namespace App\Http\Controllers;


use App\Doctor;
use App\Exam;
use App\Hospitalization;
use App\Intervention;
use App\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller {

    public function getDoctors() {
        return (Doctor::all());
    }

    public function setPatient(Request $request){


    }
   
}

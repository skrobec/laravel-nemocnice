<?php


namespace App\Http\Controllers;


use App\Patient;

class PatientController extends Controller {

    public function showPatients(){
        return view('mainViews.patients', ['patients' => Patient::all()]);
    }
}

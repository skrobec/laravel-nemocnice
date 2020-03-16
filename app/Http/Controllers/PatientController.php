<?php


namespace App\Http\Controllers;


use App\Patient;

class PatientController extends Controller {

    public function showPatient($id){
        return view('profile', ['patient' => Patient::findOrFail($id)]);
    }

    public function showPatients(){
        return view('mainViews/patients', ['patients' => Patient::all()]);
    }
}

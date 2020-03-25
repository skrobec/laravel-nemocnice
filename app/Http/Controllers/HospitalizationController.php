<?php


namespace App\Http\Controllers;


use App\Hospitalization;

class HospitalizationController extends Controller
{
    public function showHospitalizations(){
        return view('adminViews.hospitalizations', ['hospitalizations' => Hospitalization::all()]);
    }
}

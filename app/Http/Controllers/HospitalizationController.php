<?php


namespace App\Http\Controllers;


use App\Hospitalization;

class HospitalizationController extends Controller
{
    public function showHospitalizations(){
        return view('mainViews.hospitalizations');
    }

    public function showHospitalizationDetail(){
        return view('detailViews.hospitalizationDetail');
    }

    public function getHospitalizations() {
        return (Hospitalization::all());
    }

}

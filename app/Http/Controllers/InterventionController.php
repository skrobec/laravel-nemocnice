<?php


namespace App\Http\Controllers;


use App\Intervention;

class InterventionController extends Controller
{
    public function showInterventions(){
        return view('mainViews.interventions', ['interventions' => Intervention::all()]);
    }
}

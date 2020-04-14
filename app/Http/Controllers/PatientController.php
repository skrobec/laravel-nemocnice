<?php


namespace App\Http\Controllers;


use App\Patient;
use App\Exam;
use App\Hospitalization;
use App\Intervention;
use App\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller {

    public function showPatients(){
        return view('mainViews.patients');
    }

    public function addPatients(Request $request){

        $rules = array(
            'name'       => 'required',
            'issues' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        } else {
            $patient = new Patient;
            $patient->name = $request->name;
            $patient->issues = $request->issues;
            $patient->save();

            return response()->json([
                'status' => 'success',
                'msg'    => 'Okay',
            ], 201);
        }
    }

    public function editPatient(Request $request){
        $rules = array(
            'name'       => 'required',
            'issues' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        } else {
            $patient = Patient::find($request->id);
            $patient->name       = $request->name;
            $patient->issues = $request->issues;
            $patient->save();

            return response()->json([
                'status' => 'success',
                'msg'    => 'Okay',
            ], 201);
        }
    }

    public function deletePatient(Request $request){
        $patient = Patient::find($request->id);
        $patient->delete();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getPatients() {
        return (Patient::all());
    }

    public function getPatientInfo(Request $request) {
        $patient = Patient::find($request->id);
        $interventionsRaw = $patient->hospitalizations()->with('interventions')->get();
        $interventions = array();
        foreach ($interventionsRaw as $hosp){
            foreach ($hosp->interventions as $i){
                array_push($interventions, $i);
            }
        }
        return response()->json([
            'exams' => $patient->exams,
            'hospitalizations'    => $patient->hospitalizations,
            'interventions'    => $interventions,
            'servings'    => $patient->servings,
        ], 201);

    }
}

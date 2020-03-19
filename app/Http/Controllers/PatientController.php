<?php


namespace App\Http\Controllers;


use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller {

    public function showPatient($id){
        return view('profile', ['patient' => Patient::findOrFail($id)]);
    }

    public function showPatients(){
        return view('mainViews.patients', ['patients' => Patient::all()]);
    }

    public function editPatient(Request $request){
        $rules = array(
            'name'       => 'required',
            'surname'      => 'required',
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
            $patient->surname      = $request->surname;
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

    public function addPatients(Request $request){

        $rules = array(
            'name'       => 'required',
            'surname'      => 'required',
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
            $patient->name       = $request->name;
            $patient->surname      = $request->surname;
            $patient->issues = $request->issues;
            $patient->save();

            return response()->json([
                'status' => 'success',
                'msg'    => 'Okay',
            ], 201);
        }
    }

    public function getPatients() {
        return (Patient::all());
    }
}

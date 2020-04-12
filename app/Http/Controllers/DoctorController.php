<?php


namespace App\Http\Controllers;


use App\Doctor;
use App\Exam;
use App\Hospitalization;
use App\Intervention;
use App\Patient;
use App\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller {

    public function getDoctors() {
        return (Doctor::all());
    }

    public function setPatient(Request $request){
        $request->validate([
           'patient_id' => 'required|exists:patient',
            'doctor_id' => 'required|exists:doctor'
        ]);

        $patient = Patient::find($request->get('patient_id'));
        $patient->doctor_id = $request->get('doctor_id');
        $patient->save();

    }

    public function addDoctor(Request $request){
        $request->validate([
            'entry_date'=> 'required',
            'termination_date' => ''
        ]);

        $doctor = new Doctor([
            'entry_date' => $request->get('entry_date'),
            'termination_date' => $request->get('termination_date')
        ]);

        $doctor->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

}

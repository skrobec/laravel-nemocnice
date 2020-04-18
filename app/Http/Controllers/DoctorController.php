<?php


namespace App\Http\Controllers;


use App\Doctor;
use App\Patient;
use Illuminate\Http\Request;

class DoctorController extends Controller {

    public function getDoctors() {
        return (Doctor::all());
    }

    public function setPatient(Request $request){
        $request->validate([
           'patient_id' => 'required',
            'doctor_id' => 'required'
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

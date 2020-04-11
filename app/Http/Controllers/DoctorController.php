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

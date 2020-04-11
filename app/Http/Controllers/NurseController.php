<?php


namespace App\Http\Controllers;


use App\Nurse;
use App\Exam;
use App\Hospitalization;
use App\Intervention;
use App\Serving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NurseController extends Controller {

    public function getNurses() {
        return (Nurse::all());
    }

    public function addNurse(Request $request){
        $request->validate([
            'section_id'=> 'exists:section',
            'entry_date'=> 'required',
            'termination_date' => ''
        ]);

        $nurse = new Nurse([
            'section_id' => $request->get('section_id'),
            'entry_date' => $request->get('entry_date'),
            'termination_date' => $request->get('termination_date')
        ]);

        $nurse->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }
}

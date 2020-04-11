<?php


namespace App\Http\Controllers;


use App\Hospitalization;
use Illuminate\Http\Request;


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

    public function addHospitalization(Request $request){
        $request->validate([
            'date_start'=> 'required',
            'date_end'=>'',
            'reason' => 'required',
            'patient_id' => 'required|exists:patient',
            'section_id' => 'required|exists:section'
        ]);

        $hospitalization = new Hospitalization([
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'reason' => $request->get('reason'),
            'patient_id' => $request->get('patient_id'),
            'section_id' => $request->get('section_id'),
        ]);

        $hospitalization->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function editHospitalization(Request $request, $id){
        $request->validate([
            'date_start'=> 'required',
            'date_end'=>'',
            'reason' => 'required',
            'patient_id' => 'required|exists:patient',
            'section_id' => 'required|exists:section'
        ]);

        $hospitalization = Hospitalization::find($id);
        $hospitalization->date_start =  $request->get('date_start');
        $hospitalization->date_end = $request->get('date_end');
        $hospitalization->reason = $request->get('reason');
        $hospitalization->patient_id = $request->get('patient_id');
        $hospitalization->section_id = $request->get('section_id');
        $hospitalization->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteHospitalization($id){
        $hospitalization = Hospitalization::find($id);
        $hospitalization->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getHospitalizationInfo(Request $request) {
        $hospitalization = Hospitalization::find($request->id);
        return response()->json([
            'date_start' => $hospitalization->date_start,
            'date_end' => $hospitalization->date_end,
            'reason' => $hospitalization->reason,
            'patient_id' => $hospitalization->patient_id,
            'section_id' => $hospitalization->section_id,
        ], 201);
    }
}

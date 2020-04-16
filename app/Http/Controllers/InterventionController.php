<?php


namespace App\Http\Controllers;


use App\Intervention;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InterventionController extends Controller
{
    public function showInterventions(){
        return view('mainViews.interventions', ['interventions' => Intervention::all()]);
    }

    public function showInterventionDetail(){
        return view('detailViews.interventionDetail');
    }

    public function addIntervention(Request $request){
        $rules = array(
            'date'=> 'required',
            'record' => 'required',
            'patient_id' => 'required'
        );

        Log::info($request->get('date'));

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        }

        $intervention = new Intervention([
            'date' => $request->get('date'),
            'patient_id' => $request->get('patient_id'),
            'record' => $request->get('record'),
        ]);

        $intervention->save();
        $this->attachUsers($request, $intervention->id);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
            'id' => $intervention->id,
        ], 201);
    }

    private function attachUsers(Request $request, $id){
        $intervention = Intervention::find($id);
        foreach ($request->get('nurses') as $value){
            $intervention->nurses()->attach($value);

        }
        foreach ($request->get('doctors') as $value){
            $intervention->doctors()->attach($value);
        }

    }

    public function getInterventions() {
        return (Intervention::all());
    }


    public function editIntervention(Request $request, $id){
        $rules = array(
            'date'=> 'required',
            'patient_id'=>'required',
            'record' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        }

        $intervention = Intervention::find($id);
        $intervention->date =  $request->get('date');
        $intervention->patient_id = $request->get('patient_id');
        $intervention->record = $request->get('record');
        $intervention->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
            'id' => $intervention->id,
        ], 201);
    }

    public function deleteIntervention($id){
        $intervention = Intervention::find($id);
        $intervention->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getInterventionInfo(Request $request) {
        $intervention = Intervention::find($request->id);

        return response()->json([
            'date' => $intervention->date,
            'patient_id' => $intervention->patient_id,
            'record' => $intervention->record,
            'doctors' => $intervention->doctors()->with('user')->get(),
            'nurses' => $intervention->nurses()->with('user')->get(),
        ], 201);
    }
}

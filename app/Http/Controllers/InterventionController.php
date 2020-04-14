<?php


namespace App\Http\Controllers;


use App\Intervention;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InterventionController extends Controller
{
    public function showInterventions(){
        return view('mainViews.interventions', ['interventions' => Intervention::all()]);
    }

    public function showInterventionDetail(){
        return view('detailViews.interventionDetail');
    }

    public function addIntervention(Request $request){
        $request->validate([
            'date'=> 'required',
            'record' => 'required',
            'patient_id' => 'required'
        ]);

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
        $request->validate([
            'date'=> 'required',
            'patient_id'=>'required',
            'record' => 'required'
        ]);

        $intervention = Intervention::find($id);
        $intervention->date =  $request->get('date');
        $intervention->patient_id = $request->get('patient_id');
        $intervention->record = $request->get('record');
        $intervention->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
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
            'doctors' => $intervention->doctors,
            'nurses' => $intervention->nurses,
        ], 201);
    }
}

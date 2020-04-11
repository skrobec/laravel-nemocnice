<?php


namespace App\Http\Controllers;


use App\Intervention;
use Illuminate\Http\Request;

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
            'hospitalization_id'=>'required|exists:hospitalization',
            'record' => 'required'
        ]);

        $intervention = new Intervention([
            'date' => $request->get('date'),
            'hospitalization_id' => $request->get('hospitalization_id'),
            'record' => $request->get('record'),
        ]);

        $intervention->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function editIntervention(Request $request, $id){
        $request->validate([
            'date'=> 'required',
            'hospitalization_id'=>'required|exists:hospitalization',
            'record' => 'required'
        ]);

        $intervention = Intervention::find($id);
        $intervention->date =  $request->get('date');
        $intervention->hospitalization_id = $request->get('hospitalization_id');
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
            'hospitalization_id' => $intervention->hospitalization_id,
            'record' => $intervention->record,
        ], 201);
    }
}

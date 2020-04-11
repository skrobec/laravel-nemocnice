<?php

namespace App\Http\Controllers;

use App\Serving;
use Illuminate\Http\Request;

class ServingController extends Controller
{
    public function showServings(){
        return view('mainViews.servings');
    }

    public function showServingDetail(){
        return view('detailViews.servingDetail');
    }

    public function getServings() {
        return (Serving::all());
    }

    public function addServing(Request $request){
        $request->validate([
            'date'=>'required',
            'patient_id'=>'required',
            'nurse_id'=>'required'
        ]);

        $serving = new Serving([
            'date' => $request->get('date'),
            'patient_id' => $request->get('patient_id'),
            'nurse_id' => $request->get('nurse_id')
        ]);

        $serving->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function editServing(Request $request, $id){
        $request->validate([
            'date'=>'required',
            'patient_id'=>'required',
            'nurse_id'=>'required'
        ]);

        $serving = Serving::find($id);
        $serving->date =  $request->get('date');
        $serving->patient_id = $request->get('patient_id');
        $serving->nurse_id = $request->get('nurse_id');
        $serving->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteServing($id){
        $serving = Serving::find($id);
        $serving->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getServingInfo(Request $request) {
        $serving = Serving::find($request->id);
        return response()->json([
            'date' => $serving->date,
            'nurse_id'    => $serving->nurse_id,
            'patient_id'    => $serving->patient_id,
        ], 201);
    }



}

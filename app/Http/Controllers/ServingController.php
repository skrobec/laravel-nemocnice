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
            'name'=>'required',
            'description'=>'required',
        ]);

        $drug = new Drug([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);
        $drug->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function editServing(Request $request, $id){
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);

        $drug = Drug::find($id);
        $drug->name =  $request->get('name');
        $drug->description = $request->get('description');
        $drug->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteServing($id){
        $drug = Drug::find($id);
        $drug->delete();

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

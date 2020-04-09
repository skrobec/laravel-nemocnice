<?php

namespace App\Http\Controllers;

use App\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function showDrugs(){
        return view('mainViews.drugs', ["drugs" => Drug::all()]);
    }

    public function addDrug(Request $request){
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

    public function editDrug(Request $request, $id){
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

    public function deleteDrug($id){
        $drug = Drug::find($id);
        $drug->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }
}

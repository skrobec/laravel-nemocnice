<?php

namespace App\Http\Controllers;

use App\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function showDrugs(){
        return view('mainViews.drugs', ["drugs" => Drug::all()]);
    }

    public function getDrugs() {
        return (Drug::all());
    }

    public function addDrug(Request $request){
        $rules = array(
            'name'=>'required',
            'description'=>'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        } else {
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
    }

    public function editDrug(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);

        $drug = Drug::find($request->id);
        $drug->name =  $request->get('name');
        $drug->description = $request->get('description');
        $drug->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteDrug(Request $request){
        $drug = Drug::find($request->id);
        $drug->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }
}

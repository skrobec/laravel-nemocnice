<?php

namespace App\Http\Controllers;

use App\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function showDrugs(){
        return view('mainViews.drugs', ["drugs" => Drug::all()]);
    }

//    public function store(Request $request){
//        $data = $request->validate([
//            'name' => 'required|min:2',
//            'description' => 'required',
//        ]);
//
//        Drug::create($data);
//    }
}

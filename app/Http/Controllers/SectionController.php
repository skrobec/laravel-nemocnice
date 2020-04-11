<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function showSections(){
        return view('mainViews.sections', ['sections' => Section::all()]);
    }

    public function getSections() {
        return Section::all();
    }

    
    public function addSection(Request $request){
        $request->validate([
            'name'=> 'required|unique:sections|max:127',
            'capacity'=>'required|integer|min:1',
        ]);

        $section = new Section([
            'name' => $request->get('name'),
            'capacity' => $request->get('capacity'),
        ]);

        $section->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function editSection(Request $request, $id){
        $request->validate([
            'name'=>'required',
            'capacity'=>'required',
        ]);

        $section = Section::find($id);
        $section->name =  $request->get('name');
        $section->capacity = $request->get('capacity');
        $section->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteSection($id){
        $section = Section::find($id);
        $section->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getSectionInfo(Request $request) {
        $section = Section::find($request->id);
        return response()->json([
            'name' => $section->name,
            'capacity' => $section->capacity,
        ], 201);
    }

}

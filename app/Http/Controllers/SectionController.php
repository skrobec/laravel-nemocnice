<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function showSections(){
        return view('mainViews.sections', ['sections' => Section::all()]);
    }

    
}

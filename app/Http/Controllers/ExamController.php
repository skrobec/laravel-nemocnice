<?php


namespace App\Http\Controllers;


use App\Exam;

class ExamController extends Controller
{
    public function showExams(){
        return view('mainViews.exams', ['exams' => Exam::all()]);
    }
}

<?php


namespace App\Http\Controllers;


use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function showExams(){
        return view('mainViews.exams', ['exams' => Exam::all()]);
    }

    public function showExamDetail(){
        return view('detailViews.examDetail');
    }

    public function addExam(Request $request){
        $rules = array(
            'date'=> 'required',
            'record'=>'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'nurse_id' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        }

        $exam = new Exam([
            'date' => $request->get('date'),
            'record' => $request->get('record'),
            'doctor_id' => $request->get('doctor_id'),
            'patient_id' => $request->get('patient_id'),
            'nurse_id' => $request->get('nurse_id'),
        ]);

        $exam->save();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
            'id' => $exam->id,
        ], 201);
    }

    public function editExam(Request $request, $id){
        $rules = array(
            'date'=> 'required',
            'record'=>'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'nurse_id' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $validator->messages()->get('*'),
            ], 422);
        }

        $exam = Exam::find($id);
        $exam->date =  $request->get('date');
        $exam->record = $request->get('record');
        $exam->doctor_id = $request->get('doctor_id');
        $exam->patient_id = $request->get('patient_id');
        $exam->nurse_id = $request->get('nurse_id');
        $exam->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function deleteExam(Request $request){
        $exam = Exam::find($request->get('id'));
        $exam->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Okay',
        ], 201);
    }

    public function getExamInfo(Request $request) {
        $exam = Exam::find($request->id);
        return response()->json([
            'date' => $exam->date,
            'record' => $exam->record,
            'doctor_id' => $exam->doctor_id,
            'patient_id' => $exam->patient_id,
            'nurse_id' => $exam->nurse_id,
        ], 201);
    }

    public function getExams() {
        return Exam::all();
    }
}

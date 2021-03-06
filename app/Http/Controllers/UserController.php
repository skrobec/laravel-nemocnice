<?php


namespace App\Http\Controllers;


use App\Doctor;
use App\Nurse;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUsers(){
        return view('adminViews.users', ['users' => User::all()]);
    }

    public function showUserDetail(){
        return view('detailViews.userDetail');
    }

    public function getNurseUsers() {
        return User::nurse()->get();
    }

    public function getDoctorUsers() {
        return User::doctor()->notadmin()->get();
    }

    public function getUsers() {
        return User::notadmin()->get();
    }

    public function isAdmin() {
        return response()->json([
            'isAdmin' => Auth::user()->isAdmin(),
        ], 201);

    }

    public function addJob(Request $request) {
        $user = User::find($request->get('id'));

        if ($request->get('job') == "nurse"){
            $job = new Nurse([
               'entry_date' => $request->get('date'),
               'termination_date' => null,
               'section_id' => $request->get('section')
            ]);
            $user->userable_type = 'App\Nurse';
        } else {
            $job = new Doctor([
               'entry_date' => $request->get('date'),
               'termination_date' => null,
            ]);
            $user->userable_type = Doctor::class;
        }

        $job->save();
        $user->userable_id=$job->id;
        $user->save();
    }

    public function deleteUser(Request $request){

    }

    public function endJob(Request $request){
        $user = User::find($request->get('id'));
        $user->userable->termination_date = $request->get('termination_date');
        $user->userable->save();
    }

    public function getInfo(Request $request){
        $user = User::find($request->get('id'));
        if ($user->userable_type == 'App\Doctor'){
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'entry_date' => $user->userable->entry_date,
                'termination_date' => $user->userable->termination_date,
                'userable_type' => 'doctor',
                'section_id' => $user->userable->section,
            ], 201);
        } else if ($user->userable_type == 'App\Nurse') {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'entry_date' => $user->userable->entry_date,
                'termination_date' => $user->userable->termination_date,
                'userable_type' => 'nurse',
                'section_id' => $user->userable->section,
            ], 201);
        } else {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'entry_date' => '',
                'termination_date' => '',
                'userable_type' => null,
                'section_id' => '',
            ], 201);
        }
    }

}

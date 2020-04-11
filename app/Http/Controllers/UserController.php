<?php


namespace App\Http\Controllers;


use App\Doctor;
use App\Nurse;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUsers(){
        return view('adminViews.users', ['users' => User::all()]);
    }

    public function getNurseUsers() {
        return User::nurse()->get();
    }

    public function getDoctorUsers() {
        return User::doctor()->get();
    }

    public function getUsers() {
        return User::all();
    }

    public function addJob(Request $request) {
        $user = User::find($request->get('id'));

        if ($request->get('job') == "nurse"){
            $job = new Nurse([
               'entry_date' => $request->get('date'),
               'termination_date' => '',
               'section_id' => $request->get('section')
            ]);
        } else {
            $job = new Doctor([
               'entry_date' => $request->get('date'),
               'termination_date' =>'',
            ]);
        }

        $user->userable()->save($job);
    }

}

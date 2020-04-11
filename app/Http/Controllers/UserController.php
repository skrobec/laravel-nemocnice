<?php


namespace App\Http\Controllers;


use App\User;

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

}

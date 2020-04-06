<?php


namespace App\Http\Controllers;


use App\User;

class UserController extends Controller
{
    public function showUsers(){
        return view('adminViews.users', ['users' => User::all()]);
    }

}

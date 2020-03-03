<?php


namespace App\Http\Controllers;


use App\Pacient;

class PacientController extends Controller {

    public function showPacient($id){
        return view('profile', ['pacient' => Pacient::findOrFail($id)]);
    }
}

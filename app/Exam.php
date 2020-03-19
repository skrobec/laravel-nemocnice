<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    public static function findOrFail($id)
    {
        return DB::table('patients')->where('id', $id)->first();
    }

    public function exams(){
        return $this->hasMany(Exam::class);
    }
}

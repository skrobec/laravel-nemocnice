<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pacient extends Model
{
    //
    public static function findOrFail($id)
    {
        return DB::table('pacients')->where('id', $id)->first();
    }
}

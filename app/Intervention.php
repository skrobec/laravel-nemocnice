<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    public function doctors(){
        return $this->belongsToMany(Doctor::class);
    }

    public function nurses(){
        return $this->belongsToMany(Nurse::class, 'nurse_intervention');
    }

    public function hospitalization(){
        return $this->belongsTo(Hospitalization::class);
    }
}

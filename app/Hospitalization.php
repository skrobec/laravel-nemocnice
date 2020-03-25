<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function interventions(){
        return $this->hasMany(Intervention::class);
    }
}
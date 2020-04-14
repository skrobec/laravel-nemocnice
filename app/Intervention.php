<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    protected $fillable = [
      'date', 'patient_id', 'record'
    ];

    public function doctors(){
        return $this->belongsToMany(Doctor::class);
    }

    public function nurses(){
        return $this->belongsToMany(Nurse::class, 'nurse_intervention');
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}

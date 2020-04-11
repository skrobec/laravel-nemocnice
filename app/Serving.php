<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{

    protected $fillable = [
        'date', 'patient_id', 'nurse_id'
    ];

    public function drugs(){
        return $this->belongsToMany(Drug::class)->withPivot('amount');
    }

    public function nurse(){
        return $this->belongsTo(Nurse::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}

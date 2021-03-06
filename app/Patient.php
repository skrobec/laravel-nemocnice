<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
      'name', 'issues', 'doctor_id'
    ];

    public function exams(){
        return $this->hasMany(Exam::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function interventions(){
        return $this->hasMany(Intervention::class);
    }

    public function servings(){
        return $this->hasMany(Serving::class);
    }

    public function hospitalizations(){
        return $this->hasMany(Hospitalization::class);
    }
}

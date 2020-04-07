<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    public function user(){
        return $this->morphOne(User::class, 'userable');
    }

    public function exams(){
        return $this->hasMany(Patient::class);
    }

    public function interventions(){
        return $this->belongsToMany(Intervention::class, 'nurse_intervention');
    }

    public function servings(){
        return $this->hasMany(Serving::class);
    }
}

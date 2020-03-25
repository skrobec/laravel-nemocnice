<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function interventions(){
        return $this->belongsToMany(Intervention::class, 'nurse_intervention');
    }

    public function servings(){
        return $this->hasMany(Serving::class);
    }
}

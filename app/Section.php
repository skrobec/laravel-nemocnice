<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name', 'capacity'
    ];

    public function hospitalizations(){
        return $this->hasMany(Hospitalization::class);
    }

    public function nurses(){
        return $this->hasMany(Nurse::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    protected $fillable = [
        'date_start', 'date_end', 'reason', 'patient_id', 'section_id'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function scopeActive($query){
        return $query->where('date_end', null);
    }
}

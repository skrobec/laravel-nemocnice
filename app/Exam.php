<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'nurse_id', 'date', 'record'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function nurse(){
        return $this->belongsTo(Nurse::class);
    }
}

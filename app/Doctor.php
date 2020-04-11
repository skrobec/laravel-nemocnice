<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
      'entry_date', 'termination_date'
    ];

    public function user(){
        return $this->morphOne(User::class, 'userable');
    }

    public function patients(){
        return $this->hasMany(Patient::class);
    }

    public function exams(){
        return $this->hasMany(Exam::class);
    }

    public function interventions(){
        return $this->belongsToMany(Intervention::class);
    }
}

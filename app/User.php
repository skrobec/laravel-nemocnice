<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DOCTOR_TYPE = 'doctor';
    const NURSE_TYPE = 'nurse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userable(){
        return $this->morphTo();
    }

    public function isAdmin() {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isDoctor(){
        return $this->type === self::DOCTOR_TYPE;
    }

    public function isNurse(){
        return $this->type === self::NURSE_TYPE;
    }

    public function doctorDetails(){
        return $this->hasOne(Doctor::class);
    }

    public function nurseDetails(){
        return $this->hasOne(Nurse::class);
    }
}

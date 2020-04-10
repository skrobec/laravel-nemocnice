<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function servings(){
        return $this->belongsToMany(Serving::class)->withPivot('amount');
    }
}

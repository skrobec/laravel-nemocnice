<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    public function servings(){
        return $this->belongsToMany(Serving::class)->withPivot('amount');
    }
}

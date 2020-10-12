<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    public function users(){
        return $this->belongsTo(User::class);
    } 
    //
}

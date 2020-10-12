<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System_deposit extends Model
{
    //
    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

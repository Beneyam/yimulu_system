<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class yimulu_sales_sales_sync extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    } 
}

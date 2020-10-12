<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function order_status(){
        return $this->belongsTo(Order_status::class);
    } 
}

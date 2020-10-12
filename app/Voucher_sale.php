<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yimulu_sale extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    } 
    public function yimulu_sales(){
        return $this->belongsTo(yimulu_sales::class);
    } 
    public function sales_type(){
        return $this->belongsTo(Sales_type::class);
    } 
}

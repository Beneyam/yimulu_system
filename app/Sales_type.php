<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_type extends Model
{
    //
    public function yimulu_sales(){
        return $this->hasMany(Yimulu_sale::class);
    }

}

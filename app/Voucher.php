<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class yimulu_sales extends Model
{
    //
    protected $hidden = [
        'pin_number',
    ];
    
    public function yimulu_sales_type()
    {
        return $this->belongsToMany(yimulu_sales_type::class);
    }
    public function yimulu_sales(){
        return $this->hasMany(Yimulu_sale::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class yimulu_sales_type extends Model
{
    //
    public function yimulu_saless()
    {
        return $this->belongsToMany(yimulu_sales::class);
    }
}

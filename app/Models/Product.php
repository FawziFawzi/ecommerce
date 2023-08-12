<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

//    public function price()
//    {
//        return '$ '.number_format($this->price,2,'.',',');
//    }

}

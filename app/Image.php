<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['productId','name'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

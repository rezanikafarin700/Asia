<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'model', 'size', 'height', 'weight', 'gate', 'manikin', 'price','discount', 'code', 'material', 'image', 'description'];


    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

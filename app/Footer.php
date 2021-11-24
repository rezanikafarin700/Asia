<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table = 'footer';
    protected $fillable = ['description','title','image'];
    public $timestamps = false;

}

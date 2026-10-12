<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $table = 'topping';
    protected $primaryKey = 'id_topping';
    public $timestamps = false;
    protected $guarded = [];
}
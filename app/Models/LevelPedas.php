<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelPedas extends Model
{
    protected $table = 'level_pedas';
    protected $primaryKey = 'id_level';
    public $timestamps = false;
    protected $guarded = [];
}
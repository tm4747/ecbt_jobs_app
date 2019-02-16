<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatModel extends Model
{
    public static function byName($name){
        return static::where('name', $name)->firstOrFail();
    }
}

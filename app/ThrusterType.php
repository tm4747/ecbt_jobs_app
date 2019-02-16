<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThrusterType extends Model
{
    public static function byName($name){
        return static::where('name', $name)->firstOrFail();
    }
}

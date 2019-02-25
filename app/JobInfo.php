<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobInfo extends Model
{
    public static function byId($id){
        return static::where('id', $id)->firstOrFail();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public static function goal($goal_id) {
        if ($goal_id == 3) {
            return (static::yearly(2) + static::yearly(3) ) * 25;
        }
        return static::yearly($goal_id) * 25;
    }

    public static function yearly($goal_id) {
        return (static::monthly($goal_id) * 12);
    }

    public static function monthly($goal_id) {
        return static::where('goal_id', $goal_id)->sum('amount');
    }
}

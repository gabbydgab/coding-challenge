<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'date'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function setSchedule(string $title, $date)
    {
        self::updateOrCreate(
            ["date" => $date],
            ["title" => $title]
        );
    }
}

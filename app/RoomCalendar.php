<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCalendar extends Model
{
    protected $fillable = ['room_type_id', 'rate','day'];

    function RoomType(){
        // Every RoomCalendar store a reference to the RoomType and
        // it’s mandatory so we modeled it with an hasOne relationship.
        return $this->hasOne('App\RoomType');
    }
}

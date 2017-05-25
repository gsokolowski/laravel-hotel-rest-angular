<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationNight extends Model
{
    protected $fillable = ['rate', 'date', 'room_type_id'];


    // As the Reservation contain a reference to multiple nights,
    // every night contain a reference to the Reservation and the RoomType for which it was created.

    function Reservation()
    {
        return $this->hasOne('App\Reservation');
    }

    function RoomType()
    {
        return $this->hasOne('App\RoomType');
    }

}

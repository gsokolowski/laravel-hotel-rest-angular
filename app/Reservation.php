<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['total_price', 'occupancy','checkin','checkout','name'];

    public function nights()
    {
        return $this->hasMany('App\ReservationNight');
    }

    function Customer(){
        // Each Reservation need a relationship with a Customer,
        // the one who made the reservation and a list of ReservationsNights where
        // the price for each day is stored
        return $this->belongsTo('App\Customer');
    }
}

<?php

/*
 * Like the room_calendar this table store the information
 * about every single night relative to a reservation.
 * The stored information will be  the price and the room type,
 * this repeated for each reservation day.
 * This table can be very useful if we need to calculate availability for a room type in a single day
 * or to create a calendar where the hotel owner can take a look to his reservations.
 * */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservationNights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_nights', function ($table) {
            $table->increments('id');
            $table->float('rate');
            $table->date('day');
            $table->integer('room_type_id');
            $table->integer('reservation_id');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservation_nights');
    }
}

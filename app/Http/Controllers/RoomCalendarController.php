<?php
/*
 *
 * This controller will contain all the function relative to the room type by days.
 * The first function we need is to set the price for a specific room type in a date range.
 * This will be a post call with a Json payload where the start date,
 * the end date and the price will be specified.
 */
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RoomType;
use App\RoomCalendar;
use Carbon\Carbon;

class RoomCalendarController extends Controller
{

    /*
     * The function in the code above is easy to understand.
     * First it will look for the RoomType and the loop trough the dates to set the price for a specific day.
     * The response of the function is a HTTP 200 with a message indicating how many dates where updated.
     * We also set the availability of the room for the day where the price was never set.
     * This is important because we don’t want to overwrite availability for the days already in the database,
     * probably where the availability and reservation fields where modified.
     */
    public function setPriceInRangeForRoomType(Request $request)
    {
        $room_type = $request['room_type'];
        $price =  $request['price'];
        $start_dt =  $request['start_dt'];
        $end_dt =  $request['end_dt'];
        $date = date ("Y-m-d",strtotime($start_dt));

        $base_room = RoomType::find($room_type);

        $i=0;

        while (strtotime($date) <= strtotime($end_dt)) {
            $room_day =  RoomCalendar::firstOrNew(array('room_type_id' => $room_type, 'day'=>$date));

            if(!$room_day->id){
                $room_day->availability = $base_room->base_availability;
            }

            $room_day->rate = $price;
            $room_day->save();
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
            $i++;
        }

        return response("Success updated ".$i." dates",200);
    }



    public function searchAvailability(Request $request)
    {
        $start_dt = Carbon::createFromFormat('d-m-Y', $request['start_dt'])->toDateTimeString();
        $end_dt =  Carbon::createFromFormat('d-m-Y', $request['end_dt'])->toDateTimeString();


        // The first query is made on the room_type table to find
        // which room can accomodate the number of person stored in the min_occupancy variable.
        $min_occupancy = $request['min_occupancy'];
        $room_types = RoomType::where('max_occupancy','>=',$min_occupancy)->get();

        $available_room_types=array();

        // For each room type that satisfy the min_occupancy condition another query is made
        // on the room calendar table to find where this room have an availability equal to zero
        // in the dates interval selected by the user
        foreach( $room_types as $room_type){

            $count = RoomCalendar::where('day','>=',$start_dt)
                ->where('day','<',$end_dt)
                ->where('room_type_id','=',$room_type->id)
                ->where('availability','<=',0)->count();

            // If the count is zero, that mean there is at least one available,
            // for the room_type an aggregate query is made to calculate the total price.
            if($count==0){
                $total_price = RoomCalendar::where('day','>=',$start_dt)
                    ->where('day','<',$end_dt)
                    ->where('room_type_id','=',$room_type->id)
                    ->sum('rate');

                $room_type->total_price = $total_price;
                array_push($available_room_types,$room_type);
            }
        }

        // When all the info is gathered, the room_type is pushed in the $available_room_type array
        // and returned to the client. Note we used the Carbon class to operate with the date in Laravel.
        return $available_room_types;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

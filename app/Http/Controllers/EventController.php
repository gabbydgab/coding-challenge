<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "type" => "events",
            "data" => optional(Event::all())->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "title" => ["required"],
            "start_date" => ["required"],
            "end_date" => ["required"],
            "mon" => ["boolean", "nullable"],
            "tue" => ["boolean", "nullable"],
            "wed" => ["boolean", "nullable"],
            "thu" => ["boolean", "nullable"],
            "fri" => ["boolean", "nullable"],
            "sat" => ["boolean", "nullable"],
            "sun" => ["boolean", "nullable"],
        ];

        $request->validate($rules, $request->except("_token"));

        $title = $request->post('title');

        $startDate = Carbon::make($request->post('start_date'));
        $endDate = Carbon::make($request->post('end_date'));
        $period = new \DatePeriod($startDate, \DateInterval::createFromDateString("1 day"), $endDate->addDay());

        foreach ($period as $day) {
            if ($day->isMonday() && $request->post('mon')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isTuesday() && $request->post('tue')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isWednesday() && $request->post('wed')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isThursday() && $request->post('thu')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isFriday() && $request->post('fri')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isSaturday() && $request->post('sat')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            } elseif ($day->isSunday() && $request->post('sun')) {
                Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
            }
        }

        $events = Event::whereTitle($title)->orderBy("date", "ASC")->get();

        return response()->json(["type" => "event", "data" => $events->toArray(), "message" => "Saved"], 201);
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

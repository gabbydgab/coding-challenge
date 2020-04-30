<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateEventRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
     * @param  CreateEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventRequest $request)
    {
        $title = $request->post('title');

        $startDate = Carbon::make($request->post('start_date'));
        $endDate = Carbon::make($request->post('end_date'));
        $period = new \DatePeriod($startDate, \DateInterval::createFromDateString("1 day"), $endDate->addDay());

        $repeats = Collection::make([
            "Mon" => $request->post('mon'),
            "Tue" => $request->post('tue'),
            "Wed" => $request->post('wed'),
            "Thu" => $request->post('thu'),
            "Fri" => $request->post('fri'),
            "Sat" => $request->post('sat'),
            "Sun" => $request->post('sun'),
        ]);

        foreach ($period as $day) {
            $repeats->each(function($value, $key) use ($day, $title)  {
                if (($key === $day->getTranslatedShortDayName()) && $value) {
                    Event::updateOrCreate(["date" => $day->format("Y-m-d")],["title" => $title]);
                }
            });
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

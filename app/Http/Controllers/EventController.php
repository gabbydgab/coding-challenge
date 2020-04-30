<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

    public function store(CreateEventRequest $request) : JsonResource
    {
        foreach ($request->datesFromTheSelectedPeriod() as $date) {
            $request->selectedDay()->each(function($isSelected, $day) use ($date, $request)  {
                if (($day === $date->getTranslatedShortDayName()) && $isSelected) {
                    Event::setSchedule($request->eventTitle(), $date);
                }
            });
        }

        // maybe you can have $request->notifyListeners() before you return the api resource

        return $request->jsonResourceResponse();
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

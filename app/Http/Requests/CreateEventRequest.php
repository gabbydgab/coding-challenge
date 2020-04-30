<?php

namespace App\Http\Requests;

use App\Event;
use App\Http\Resources\AddedEventCollection;
use App\Http\Resources\EventResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
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
    }

    /**
     * We need to add 1 day since the period doesn't count the last day due to the interval.
     *
     * If you select the same date from 2020-02-01 to 2020-02-01 then the number of days will still be 1
     *
     * @return \DatePeriod
     */
    public function datesFromTheSelectedPeriod() : \DatePeriod
    {
        return new \DatePeriod(
            Carbon::make($this->start_date),
            \DateInterval::createFromDateString("1 day"),
            Carbon::make($this->end_date)->addDay()
        );
    }

    /**
     * We need to transform the index (key) corresponding to Carbon::getTranslatedShortDayName()
     * @return Collection
     */
    public function selectedDay() : Collection
    {
        return Collection::make([
            "Mon" => $this->mon,
            "Tue" => $this->tue,
            "Wed" => $this->wed,
            "Thu" => $this->thu,
            "Fri" => $this->fri,
            "Sat" => $this->sat,
            "Sun" => $this->sun,
        ]);
    }

    public function eventTitle() : string
    {
        return $this->title;
    }

    public function jsonResourceResponse() : JsonResource
    {
        return AddedEventCollection::make(
            EventResource::collection(
                Event::whereTitle($this->eventTitle())->orderBy("date", "ASC")->get()
            )
        );
    }
}

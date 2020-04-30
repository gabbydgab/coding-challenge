<?php

namespace Tests\Feature\Schedule;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function sameDayEvent()
    {
        $payload = [
            "title" => "Conference Keynote",
            "start_date" => "2020-05-25",
            "end_date" => "2020-05-25",
            "mon" => true,
        ];

        $response = $this->postJson(route('events.store'), $payload);

        $events = Event::whereTitle("Conference Keynote")->orderBy("date", "ASC")->get();

        // just 1 because it's a same day event
        $this->assertEquals(1, $events->count());

        $response->assertStatus(201)
            ->assertJsonFragment([
                "type" => "event",
                "message" => "Saved",
                "data" => $events->toArray(),
            ]);
    }

    /**
     * @test
     */
    public function scheduleEveryWeekendsForTheMonthOfMay()
    {
        $payload = [
            "title" => "Coding because I have no life",
            "start_date" => "2020-05-01",
            "end_date" => "2020-05-31",
            "sat" => true,
            "sun" => true,
        ];

        $response = $this->postJson(route('events.store'), $payload);


        $events = Event::whereTitle("Coding because I have no life")->orderBy("date", "ASC")->get();

        // Should equal to 10 events since there are 5 Saturdays and 5 Sundays for May 2020
        $this->assertEquals(10, $events->count());

        $response->assertStatus(201)
            ->assertJsonFragment([
                "type" => "event",
                "message" => "Saved",
                "data" => $events->toArray(),
            ]);
    }

    /**
     * @test
     */
    public function scheduleEveryWorkDaysForTheMonthOfMay()
    {
        $payload = [
            "title" => "Coding at work",
            "start_date" => "2020-05-01",
            "end_date" => "2020-05-31",
            "mon" => true,
            "tue" => true,
            "wed" => true,
            "thu" => true,
            "fri" => true,
        ];

        $response = $this->postJson(route('events.store'), $payload);


        $events = Event::whereTitle("Coding at work")->orderBy("date", "ASC")->get();

        // Should equal to 21 events since there are 10-days weekend for May 2020
        $this->assertEquals(21, $events->count());

        $response->assertStatus(201)
            ->assertJsonFragment([
                "type" => "event",
                "message" => "Saved",
                "data" => $events->toArray(),
            ]);
    }
}

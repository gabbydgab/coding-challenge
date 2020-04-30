<?php

namespace Tests\Feature\Schedule;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function showAllEvents()
    {

        factory(Event::class)->create(['title' => $this->faker->word]);
        factory(Event::class)->create(['title' => $this->faker->word]);
        $events = Event::all();

        $response = $this->getJson(route('events.index'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                "type" => "events",
                "data" => $events->toArray(),
            ]);

        $this->assertEquals(2, $events->count());
    }
}

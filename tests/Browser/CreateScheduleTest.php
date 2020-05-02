<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CalendarPage;
use Tests\DuskTestCase;

class CreateScheduleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function scheduleForHaircut() : void
    {
        $this->browse(function (Browser $browser) {

            $title = "For haircut";

            $date = now();
            $mm = in_array($date->month, [12, 11, 10]) ? "0{$date->month}" : $date->month;
            $day = random_int(1, 30);
            $date = "$mm/$day/$date->year";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleOnceFor($title, $date)
                ->click("#save")
                ->waitUntilMissingText($title)
                ->waitForText("Save");
        });
    }

    /**
     * @test
     */
    public function overrideGymAppointmentToEatingIceCream() : void
    {
        $this->browse(function (Browser $browser) {

            $appointment1 = "Gym";
            $appointment2 = "Eat all-you-can Ice Cream";

            $date = now();
            $mm = in_array($date->month, [12, 11, 10]) ? "0{$date->month}" : $date->month;
            $day = random_int(1, 30);
            $date = "$mm/$day/$date->year";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleOnceFor($appointment1, $date)
                ->click("#save")
                ->waitUntilMissingText($appointment1)
                ->scheduleOnceFor($appointment2, $date)
                ->click("#save")
                ->waitUntilMissingText($appointment2)
                ->waitForText("Save");
        });
    }

    /**
     * Scheduled for working days
     * @test
     */
    public function dailyHuddleAtWork() : void
    {
        $this->browse(function (Browser $browser) {

            $title = "Daily huddle";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleWeekdaysFor($title)
                ->click("#save")
                ->waitUntilMissingText($title)
                ->waitForText("Save");
        });
    }

    /**
     * Scheduled for weekends
     * @test
     */
    public function prototypingYourStartUpApplicationOnWeekends() : void
    {
        $this->browse(function (Browser $browser) {

            $title = "Prototyping my startup application";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleWeekendsFor($title)
                ->click("#save")
                ->waitUntilMissingText($title)
                ->waitForText("Save");
        });
    }

    /**
     * A month long schedule - in short, it's everyday
     * @test
     */
    public function noFacebookForAMonth()
    {
        $this->browse(function (Browser $browser) {

            $title = "NO Facebook";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleForOneMonth($title)
                ->click("#save")
                ->waitUntilMissingText($title)
                ->waitForText("Save");
        });
    }
}

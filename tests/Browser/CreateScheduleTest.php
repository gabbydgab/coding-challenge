<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CalendarPage;
use Tests\DuskTestCase;

class CreateScheduleTest extends DuskTestCase
{
    /**
     * A month long schedule - in short, it's everyday
     * @test
     */
    public function noFacebookForAMonth()
    {
        $this->withoutExceptionHandling();
        $this->browse(function (Browser $browser) {

            $title = "NO Facebook";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleForOneMonth($title)
                ->click("#save")
                ->waitUntilMissingText($title);
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
                ->waitUntilMissingText($title);
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
                ->waitUntilMissingText($title);
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

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleOnceAMonthFor($appointment1)
                ->click("#save")
                ->waitUntilMissingText($appointment1)
                ->scheduleOnceAMonthFor($appointment2)
                ->click("#save")
                ->waitUntilMissingText($appointment2);
        });
    }

    /**
     * @test
     */
    public function scheduleForPayrollNextMonth() : void
    {
        $this->browse(function (Browser $browser) {

            $title = "Collect Payroll";

            $browser->visit(new CalendarPage())
                ->waitForText("Calendar")
                ->scheduleOnceAMonthFor($title)
                ->click("#save")
                ->waitUntilMissingText($title);
        });
    }
}

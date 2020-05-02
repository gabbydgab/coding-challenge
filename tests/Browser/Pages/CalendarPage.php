<?php

namespace Tests\Browser\Pages;

use Carbon\Carbon;
use Laravel\Dusk\Browser;

class CalendarPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    public function scheduleForOneMonth(Browser $browser, string $title)
    {
        $month = now();
        $mm = in_array($month->month, [12, 11, 10]) ? "0{$month->month}" : $month->month;
        $browser->type('#title', $title)
            ->type('#start_date', "{$mm}/01/2020")
            ->type('#end_date', "{$mm}/30/2020")
            ->check("#mon")
            ->check("#tue")
            ->check("#wed")
            ->check("#thu")
            ->check("#fri")
            ->check("#sat")
            ->check("#sun");
    }

    public function scheduleWeekdaysFor(Browser $browser, string $title)
    {
        $month = now();
        $mm = in_array($month->month, [12, 11, 10]) ? "0{$month->month}" : $month->month;
        $browser->type('#title', $title)
            ->type('#start_date', "{$mm}/01/2020")
            ->type('#end_date', "{$mm}/30/2020")
            ->check("#mon")
            ->check("#tue")
            ->check("#wed")
            ->check("#thu")
            ->check("#fri");
    }

    public function scheduleWeekendsFor(Browser $browser, string $title)
    {
        $month = now();
        $mm = in_array($month->month, [12, 11, 10]) ? "0{$month->month}" : $month->month;
        $browser->type('#title', $title)
            ->type('#start_date', "{$mm}/01/2020")
            ->type('#end_date', "{$mm}/30/2020")
            ->check("#sat")
            ->check("#sun");
    }

    /**
     * We need to check all the days for it to work because we wouldn't know on what day the date will turn out.
     *
     * @param Browser $browser
     * @param string $title
     * @param string $date
     */
    public function scheduleOnceFor(Browser $browser, string $title, string $date)
    {
        $browser->type('#title', $title)
            ->type('#start_date', $date)
            ->type('#end_date', $date)
            ->check("#mon")
            ->check("#tue")
            ->check("#wed")
            ->check("#thu")
            ->check("#fri")
            ->check("#sat")
            ->check("#sun");
    }
}

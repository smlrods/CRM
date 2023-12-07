<?php

use Illuminate\Support\Carbon;

if (! function_exists('generateDateRange')) {
    function generateDateRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = collect();

        while ($startDate->lte($endDate)) {
            $dates->push($startDate->copy());
            $startDate->addDay();
        }

        return $dates;
    }
}

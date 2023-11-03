<?php

namespace App\Http\Controllers\TraitClass;

use App\Http\Controllers\Paytm\PaytmChecksum;

trait IsTwentyfourHourDifferenceTrait
{

    // validate 24hrs time
    private function isLessThenTwentyfourHour($booking_date, $booking_time)
    {
        $result = true;
        $date2 = date_create(date('Y-m-d'));
        $date1 = date_create(date('Y-m-d', strtotime($booking_date)));
        $diff = date_diff($date2, $date1);
        if (date('d-m-Y') !== $booking_date && $diff->format("%R%a") > 0) {
            if (intval($diff->format("%R%a")) === 1 && strtotime(date('H:i', strtotime($booking_time))) < strtotime(date('H:i'))) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }
}

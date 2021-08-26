<?php

namespace App\Helpers;
use Carbon\Carbon;

class DateFilter
{
    /**
     * Class that return a date from a request string
     *
     */

    /**
     * @param $request
     * @return date
     */

    public static function getFilterDate($requestDate){
        if($requestDate){
            switch ($requestDate) {
                case 'today':
                    $date = Carbon::now()->format('Y-m-d');
                    break;

                case 'tomorrow':
                    $date = new Carbon('tomorrow');
                    $date = $date->format('Y-m-d');
                    break;

                case 'after_tomorrow':
                    $date = Carbon::now()->addDays(2)->format('Y-m-d');
                    break;

                default:
                    $date = "";
                    break;
            }
            return $date;
        }

        return false;
    }

}

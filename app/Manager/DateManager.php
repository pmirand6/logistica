<?php


namespace App\Manager;

use Carbon\Carbon;

class DateManager
{

    /**
     * @return mixed|null
     */
    public function getTodayName()
    {
        return $this->searchByDayName(Carbon::parse(Carbon::now())->format('l'));

    }

    /**
     * @param $dayName
     * @return mixed|null
     */
    private function searchByDayName($dayName) {

        $array = config('dateConfig.DIAS');
        foreach ($array as $key => $val) {
            if ($val['en'] === $dayName) {
                return $val['es'];
            }
        }
        return null;
    }

}

<?php


namespace App\Repositories\Holidays;


interface HolidaysRepositoryInterface
{
    public function store(array $request);

    public function get();

    public function getFromApi(string $year, string $month, string $day);

    public function all();
}

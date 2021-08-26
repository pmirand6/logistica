<?php
/**
 * Class RoadMapInterface
 * @package App\Repositories\RoadMap
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 2/12/20 13:08
 */

namespace App\Repositories\RoadMap;


interface RoadMapInterface
{

    public function index();

    public function show();

    public function getByDriver();

    public function store($request);


}

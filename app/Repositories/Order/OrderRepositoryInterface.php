<?php
/**
 * Class OrderRepositoryInterface
 * @package App\Repositories\Order
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 14:57
 */

namespace App\Repositories\Order;


interface OrderRepositoryInterface
{
    public function index();

    public function show($orderCode);

    public function store($request);

    public function updateOrder($request, $orderCode);

    public function getOrdersByDriver($driverId, $date);

}

<?php
namespace App\Repositories\PurchaseOrder;

interface PurchaseOrderRepositoryInterface
{
    public function index();

    public function show($purchaseOrderCode);

    public function store($purchaseOrderCode);

}

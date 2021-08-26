<?php


namespace App\Repositories\Admin;


interface AdminRepositoryInterface
{
    public function index();

    public function show($field, $request);

    public function store($request);

    public function update($request);

}

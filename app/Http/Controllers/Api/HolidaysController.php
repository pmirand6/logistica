<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Holidays;
use App\Repositories\Holidays\HolidaysRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HolidaysController extends Controller
{
    /**
     * @var HolidaysRepositoryInterface
     */
    private $holidaysRepository;

    public function __construct(HolidaysRepositoryInterface $holidaysRepository)
    {
        $this->holidaysRepository = $holidaysRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->holidaysRepository->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return Response
     */
    public function show(Holidays $holidays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return Response
     */
    public function edit(Holidays $holidays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holidays  $holidays
     * @return Response
     */
    public function update(Request $request, Holidays $holidays)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return Response
     */
    public function destroy(Holidays $holidays)
    {
        //
    }
}

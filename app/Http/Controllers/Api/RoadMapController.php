<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\RoadMap\RoadMapInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RoadMapController extends Controller
{

    /**
     * @var RoadMapInterface
     */
    private $roadMapInterface;

    public function __construct(RoadMapInterface $roadMapInterface)
    {
        $this->roadMapInterface = $roadMapInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->roadMapInterface->index();
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->roadMapInterface->store($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\RoadMap  $roadMap
     * @return Response
     */
    public function update(Request $request, RoadMap $roadMap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RoadMap $roadMap
     * @return Response
     */
    public function destroy(RoadMap $roadMap)
    {
        //
    }

    public function getByDriver($orderCode)
    {
        return $this->roadMapInterface->getByDriver();
    }
}

<?php

namespace App\Events;

use App\Models\Roadmap\Roadmap;
use Illuminate\Http\Request;

class RoadmapCreated extends Event
{
    /**
     * @var Roadmap
     */
    public $roadmap;

    /**
     * Create a new event instance.
     *
     * @param Roadmap $roadmap
     */
    public function __construct(Roadmap $roadmap)
    {
        $this->roadmap = $roadmap;
    }
}

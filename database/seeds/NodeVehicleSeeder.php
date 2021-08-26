<?php
use App\Models\Node\Node;
use App\Models\NodeVehicle;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Seeder;

class NodeVehicleSeeder extends Seeder
{
    public function run()
    {
        NodeVehicle::truncate();

        $nodes = Node::all();
        $vehicles = Vehicle::all();

        foreach ($nodes as $n) {
            foreach ($vehicles as $v) {
                $v->node()->attach($n);
            }
        }
    }
}

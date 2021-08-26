<?php

use App\Models\Node\Node;
use Illuminate\Database\Seeder;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nodeCount = Node::count();
        if($nodeCount == 0){
            factory(Node::class)->times(1)->create();
        }

    }
}

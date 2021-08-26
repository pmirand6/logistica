<?php


use App\Models\Admins\Admins;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admins::class)->times(5)->create();
    }

}

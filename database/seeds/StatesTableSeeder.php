<?php

use App\County;
use App\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(State::class, 5)->create()->each(function (State $state) {
            $state->counties()->saveMany(factory(County::class, rand(3,10))->make());
        });
    }
}

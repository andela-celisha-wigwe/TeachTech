<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        factory('TeachTech\Video', 5)->create();

        factory('TeachTech\Comment', 15)->create();

        factory('TeachTech\User', 5)->create();

        factory('TeachTech\Category', 4)->create();

        Model::reguard();
    }
}

<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PatientsTableSeeder::class);

        $this->call(ExamsTableSeeder::class);

        $this->call(DrugsTableSeeder::class);

        $this->call(SectionsTableSeeder::class);

        Model::reguard();
    }
}

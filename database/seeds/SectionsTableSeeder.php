<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();

        DB::table('sections')->insert([
            'name' => 'Chirurgie',
            'capacity' => 42,
        ]);
    }
}

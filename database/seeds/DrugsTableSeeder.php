<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drugs')->delete();

        DB::table('drugs')->insert([
            'name' => 'Paralen',
            'description' => "lék na bolest",
        ]);

        DB::table('drugs')->insert([
            'name' => 'Ibuprofen',
            'description' => "bolest zad",
        ]);

        DB::table('drugs')->insert([
            'name' => 'DBG-24',
            'description' => "ředění krve",
        ]);

        DB::table('drugs')->insert([
            'name' => 'OEL-8',
            'description' => "zázračný lék",
        ]);
    }
}

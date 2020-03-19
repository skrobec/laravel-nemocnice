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
            'name' => 'Lektvar',
            'description' => "Lek na nejaky blbosti",
        ]);
    }
}

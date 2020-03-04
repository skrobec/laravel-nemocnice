<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacientsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('pacients')->insert([
            'name' => "Jan",
            'surname' => "Novák",
            'issues' => "dychaci obtize blablabla",
        ]);
    }
}

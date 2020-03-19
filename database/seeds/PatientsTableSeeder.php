<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('patients')->delete();

        DB::table('patients')->insert([
            'name' => "Jan",
            'surname' => "Novák",
            'issues' => "dychaci obtize blablabla",
        ]);

        DB::table('patients')->insert([
            'name' => "Josef",
            'surname' => "Slepý",
            'issues' => "blouzni",
        ]);

        DB::table('patients')->insert([
            'name' => "František",
            'surname' => "Starý",
            'issues' => "zlomena noha",
        ]);
    }
}

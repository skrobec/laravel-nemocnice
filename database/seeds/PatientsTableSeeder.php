<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('patients')->delete();

        DB::table('patients')->insert([
            'name' => "Jan Novák",
            'issues' => "dychaci obtize blablabla",
            'doctor_id' => 1,
        ]);

        DB::table('patients')->insert([
            'name' => "Josef Slepý",
            'issues' => "blouzni",
            'doctor_id' => 2,
        ]);

        DB::table('patients')->insert([
            'name' => "František Starý",
            'issues' => "zlomena noha",
            'doctor_id' => 1,
        ]);
    }
}

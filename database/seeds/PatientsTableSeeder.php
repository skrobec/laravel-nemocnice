<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('patients')->delete();

        DB::table('patients')->insert([
            'name' => "Jan Novák",
            'issues' => "Dýchací obtíže",
            'doctor_id' => 1,
        ]);

        DB::table('patients')->insert([
            'name' => "Josef Slepý",
            'issues' => "Horečka a kašel",
            'doctor_id' => 2,
        ]);

        DB::table('patients')->insert([
            'name' => "František Starý",
            'issues' => "Zlomená noha",
            'doctor_id' => 1,
        ]);
    }
}

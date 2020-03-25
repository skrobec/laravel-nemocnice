<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorInterventionTableSeeder extends Seeder
{
    public function run(){
        DB::table('doctor_intervention')->delete();

        DB::table('doctor_intervention')->insert([
           'doctor_id' => 1,
           'intervention_id' => 1,
        ]);

        DB::table('doctor_intervention')->insert([
            'doctor_id' => 2,
            'intervention_id' => 1,
        ]);

        DB::table('doctor_intervention')->insert([
            'doctor_id' => 3,
            'intervention_id' => 1,
        ]);

        DB::table('doctor_intervention')->insert([
            'doctor_id' => 1,
            'intervention_id' => 2,
        ]);

        DB::table('doctor_intervention')->insert([
            'doctor_id' => 3,
            'intervention_id' => 2,
        ]);
    }
}

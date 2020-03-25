<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NurseInterventionTableSeeder extends Seeder
{
    public function run(){
        DB::table('nurse_intervention')->delete();

        DB::table('nurse_intervention')->insert([
           'nurse_id' => 1,
           'intervention_id' => 1,
        ]);
    }
}

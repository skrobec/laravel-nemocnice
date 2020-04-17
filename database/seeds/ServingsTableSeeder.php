<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServingsTableSeeder extends Seeder
{
    public function run(){
        DB::table('servings')->delete();

        DB::table('servings')->insert([
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'nurse_id' => 1,
            'patient_id' => 1,
        ]);

        DB::table('servings')->insert([
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'nurse_id' => 2,
            'patient_id' => 1,
        ]);
    }
}

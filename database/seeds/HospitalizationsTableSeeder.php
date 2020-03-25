<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalizationsTableSeeder extends Seeder
{
    public function run(){
        DB::table('hospitalizations')->delete();

        DB::table('hospitalizations')->insert([
            'date_start' => Carbon::now()->format('Y-m-d H:i:s'),
            'date_end' => Carbon::now()->format('Y-m-d H:i:s'),
            'reason' => "bylo mu blbě",
            'patient_id' => 1,
            'section_id' =>1,
        ]);
    }
}

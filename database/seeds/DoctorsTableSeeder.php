<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsTableSeeder extends Seeder
{
    public function run(){
        DB::table('doctors')->delete();

        DB::table('doctors')->insert([
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('doctors')->insert([
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('doctors')->insert([
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

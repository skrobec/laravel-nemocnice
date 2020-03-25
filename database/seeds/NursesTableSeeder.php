<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NursesTableSeeder extends Seeder
{
    public function run(){
        DB::table('nurses')->delete();

        DB::table('nurses')->insert([
            'user_id' => 4,
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('nurses')->insert([
            'user_id' => 5,
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('nurses')->insert([
            'user_id' => 6,
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

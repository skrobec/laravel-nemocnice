<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NursesTableSeeder extends Seeder
{
    public function run(){
        DB::table('nurses')->delete();

        DB::table('nurses')->insert([
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => null,
        ]);

        DB::table('nurses')->insert([
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => null,
        ]);

        DB::table('nurses')->insert([
            'section_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'termination_date' => null,
        ]);
    }
}

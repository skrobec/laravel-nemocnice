<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{
    public function run(){
        DB::table('exams')->delete();

        DB::table('exams')->insert([
            'datum' => Carbon::now()->format('Y-m-d H:i:s'),
            'patient_id' => 1,
            'zapis' => "Exam probehlo v poradku.",
        ]);
    }


}
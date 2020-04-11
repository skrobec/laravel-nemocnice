<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{
    public function run(){
        DB::table('exams')->delete();

        DB::table('exams')->insert([
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'patient_id' => 1,
            'doctor_id' => 1,
            'nurse_id' => 1,
            'record' => "Exam probehlo v poradku.",
        ]);
    }


}

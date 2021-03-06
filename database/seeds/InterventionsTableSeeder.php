<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterventionsTableSeeder extends Seeder
{
    public function run(){
        DB::table('interventions')->delete();

        DB::table('interventions')->insert([
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'patient_id' => 1,
            'record' => 'Provedena operace v oblasti hrudníku. Vše v pořádku.',
        ]);

        DB::table('interventions')->insert([
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'patient_id' => 1,
            'record' => 'Mírné komplikace probrání z narkózy. Řešeno přidáním kyslíku.',
        ]);
    }
}

<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugServingTableSeeder extends Seeder
{
    public function run(){
        DB::table('drug_serving')->delete();

        DB::table('drug_serving')->insert([
           'drug_id' => 1,
           'serving_id' =>1,
           'amount' => 10,
        ]);
    }
}

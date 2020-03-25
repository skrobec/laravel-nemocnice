<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(){
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'TestDoktor1',
            'email' => 'test1@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 0,
            'doctor_id' => 1,
            'nurse_id' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'TestDoktor2',
            'email' => 'test2@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 0,
            'doctor_id' => 1,
            'nurse_id' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'TestDoktor3',
            'email' => 'test3@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 0,
            'doctor_id' => 1,
            'nurse_id' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra1',
            'email' => 'test1@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 1,
            'doctor_id' => 0,
            'nurse_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra2',
            'email' => 'test2@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 1,
            'doctor_id' => 0,
            'nurse_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra3',
            'email' => 'test3@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' => '123456789',
            'type' => 1,
            'doctor_id' => 0,
            'nurse_id' => 1,
        ]);
    }
}

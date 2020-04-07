<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(){
        DB::table('users')->delete();

        DB::table('users')->insert([
           'name' => 'Admin',
           'email' => 'admin@a.com',
           'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'password' => Hash::make('admin'),
           'type' => 'admin',
           'userable_type' => 'App\Doctor',
           'userable_id' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'TestDoktor1',
            'email' => 'test1@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'TestDoktor2',
            'email' => 'test2@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'TestDoktor3',
            'email' => 'test3@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 3,
        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra1',
            'email' => 'test1@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 1,

        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra2',
            'email' => 'test2@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'TestSestra3',
            'email' => 'test3@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 3,
        ]);
    }
}

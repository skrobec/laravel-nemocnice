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
           'userable_type' => null,
        ]);

        DB::table('users')->insert([
            'name' => 'Marek Petr',
            'email' => 'test1@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Milan Petr',
            'email' => 'test2@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Michaela Netopilová',
            'email' => 'test3@test.test',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Doctor',
            'userable_id' => 3,
        ]);

        DB::table('users')->insert([
            'name' => 'Jitka Nová',
            'email' => 'test1@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 1,

        ]);

        DB::table('users')->insert([
            'name' => 'Petra Mladá',
            'email' => 'test2@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Kristýna Tichá',
            'email' => 'test3@test.testt',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'password' =>  Hash::make('123456789'),
            'userable_type' => 'App\Nurse',
            'userable_id' => 3,
        ]);
    }
}

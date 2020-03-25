<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);

        $this->call(PatientsTableSeeder::class);

        $this->call(ExamsTableSeeder::class);

        $this->call(DrugsTableSeeder::class);

        $this->call(SectionsTableSeeder::class);

        $this->call(DoctorsTableSeeder::class);

        $this->call(NursesTableSeeder::class);

        $this->call(InterventionsTableSeeder::class);

        $this->call(DoctorInterventionTableSeeder::class);

        $this->call(NurseInterventionTableSeeder::class);

        $this->call(ServingsTableSeeder::class);

        $this->call(DrugServingTableSeeder::class);

        $this->call(HospitalizationsTableSeeder::class);

        Model::reguard();
    }
}

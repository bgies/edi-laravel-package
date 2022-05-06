<?php

namespace Database\Seeders;

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
        /* ALWAYS Seed the lookup tables first */
        $this->call(EDIGroupSeeder::class);
        $this->call(EDITypeSeeder::class);
        $this->call(EdiTransmissionsSeeder::class);
        $this->call(EdiStateSeeder::class);
        $this->call(EdiOutgoingStatusSeeder::class);
        $this->call(EdiTypesId3Seeder::class);
        //$this->call(UserSeeder::class);
        
        /* now the normal tables */
    }
}

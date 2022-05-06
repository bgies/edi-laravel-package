<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EdiStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('edi_states')->truncate();
        \DB::table('edi_states')->insert([
            [
                'id' => 1,
                'state_name' => 'Unknown'
            ],
            [
                'id' => 2,
                'state_name' => 'Started'
            ],
            [
                'id' => 3,
                'state_name' => 'Translating Started'
            ],
            [
                'id' => 4,
                'state_name' => 'Translating Finished'
            ],
            [
                'id' => 5,
                'state_name' => 'File Moved'
            ],
            [
                'id' => 6,
                'state_name' => 'Transmitting Started'
            ],
            [
                'id' => 7,
                'state_name' => 'Transmitted'
            ],
            [
                'id' => 8,
                'state_name' => '997 Rejected'
            ],
            [
                'id' => 9,
                'state_name' => '997 Accepted'
            ],
            [
                'id' => 10,
                'state_name' => 'Data Accepted'
            ],
            [
                'id' => 11,
                'state_name' => 'Reply Received'
            ],
            [
                'id' => 12,
                'state_name' => 'Done'
            ],
            [
                'id' => 13,
                'state_name' => 'Archived'
            ]
           ]);
    }
}

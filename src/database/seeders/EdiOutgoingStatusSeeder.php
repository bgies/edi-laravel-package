<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EdiOutgoingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('edi_outgoing_status')->truncate();
        \DB::table('edi_outgoing_status')->insert([
            [
                'id' => 1,
                'status_name' => 'File Created',
                'status_description' => 'The file was created'
            ],
            [
                'id' => 2,
                'status_name' => 'File Saved',
                'status_description' => 'the file was saved to long term storage'
            ],
            [
                'id' => 3,
                'status_name' => 'Transmitted',
                'status_description' => 'The file was transmitted to the trading partner'
            ],
            [
                'id' => 4,
                'status_name' => 'Acknowledged',
                'status_description' => 'The Trading Partner acknowledged receiving the file'
            ],
            [
                'id' => 5,
                'status_name' => 'Rejected',
                'status_description' => 'The file was rejected by the Trading Partner (usually means bad data)'
            ],
            [
                'id' => 6,
                'status_name' => 'Partially Accepted',
                'status_description' => 'The data in the file was partially accepted by the Trading Partner'
            ],
            [
                'id' => 7,
                'status_name' => 'Accepted',
                'status_description' => 'The file was accepted by the Trading Partne'
            ],
            [
                'id' => 8,
                'status_name' => 'Finished',
                'status_description' => 'We are done with this file'
            ],
            [
                'id' => 9,
                'status_name' => 'Archived',
                'status_description' => 'The file has been archived'
            ]
        ]);


    }
}

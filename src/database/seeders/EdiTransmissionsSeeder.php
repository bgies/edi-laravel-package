<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EdiTransmissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('edi_transmissions')->truncate();
        \DB::table('edi_transmissions')->insert([
            [
                // normal property settings
                'id' => 1,
                'etr_name' => 'FTP - Not encrypted'
            ],
            [
                // normal property settings
                'id' => 2,
                'etr_name' => 'FTP - PGP Encrypted'
            ],
            [
                // normal property settings
                'id' => 3,
                'etr_name' => 'FTP - Lexicom'
            ],
            [
                // normal property settings
                'id' => 4,
                'etr_name' => 'FTPS (ssl)'
            ],
            [
                // normal property settings
                'id' => 5,
                'etr_name' => 'FTP Command List'
            ],
            [
                // normal property settings
                'id' => 6,
                'etr_name' => 'FTPS Command List (ssl)'
            ],
            [
                // normal property settings
                'id' => 7,
                'etr_name' => 'SMTP (email()'
            ],
            [
                // normal property settings
                'id' => 8,
                'etr_name' => 'File Drop'
            ],
            [
                // normal property settings
                'id' => 9,
                'etr_name' => 'SFTP'
            ],
            [
                // normal property settings
                'id' => 10,
                'etr_name' => 'File From Directory'
            ],
            [
                // normal property settings
                'id' => 11,
                'etr_name' => 'Stored Procedure'
            ],
            [
                // normal property settings
                'id' => 12,
                'etr_name' => 'SP-MasterDetail'
            ]
            
            
            
            
            
            // NOTE - Custom Transmission Object should be given an id of 1001 or higher.
        ]);
    }
}

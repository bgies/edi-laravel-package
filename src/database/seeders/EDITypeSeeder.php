<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EDITypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('edi_types')->delete(1);
        \DB::table('edi_types')->delete(2);
        
        \DB::table('edi_types')->insert([
          [
              // normal property settings
             'id' => 1,
             'edt_name' => 'Read850',
             'edt_is_incoming' => 1,
             'edt_edi_standard' => 'X12',
             'edt_transaction_set_name' => '850',
             'edt_enabled' => 1,
             'edt_file_directory' => '',
             'edt_edi_object' =>  null,
             'interchange_sender_id' => 'VENDOR1',
             'interchange_receiver_id' => 'MYCOMPANY',
             'application_sender_code' => 'VENDOR1',
             'application_receiver_code' => 'MYCOMPANY_PO',
              // specific to this object
//             'edt_beforeProcessObjectType' => 10,
//             'edt_after_process_Type' => 1001
          ],
            [
                // normal property settings
                'id' => 2,
                'edt_name' => 'Send855',
                'edt_is_incoming' => 0,
                'edt_edi_standard' => 'X12',
                'edt_transaction_set_name' => '855',
                'edt_enabled' => 1,
                'edt_file_directory' => '',
                'edt_edi_object' =>  null,
                'interchange_sender_id' => 'MYCOMPANY',
                'interchange_receiver_id' => 'VENDOR1',
                'application_sender_code' => 'MYCOMPANY_POA',
                'application_receiver_code' => 'VENDOR1',
                // specific to this object
//                'edtBeforeProcessObjectType' => 11,
//                'edtAfterSendProcessingType' => 1001
            ]
        ]);
    }
}

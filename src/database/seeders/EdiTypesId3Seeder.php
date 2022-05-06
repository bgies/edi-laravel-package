<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\EdiLaravel\FileHandling\FileFromDirectory;
use Bgies\EdiLaravel\FileHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Models\EdiTypes;

use Bgies\EdiLaravel\Lib\X12\ReplySettings;


class EdiTypesId3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setup the preProcess object
        $beforeProcessObject = new FileFromDirectory();
        $beforeProcessObject->edt_file_directory = 'incoming/Read852';


        // Setup the main Options object
        $options = new \Bgies\EdiLaravel\Lib\X12\Options\Read\Read852Options();
        $options->dataInterchangeControlNumber = 0;
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverID = 'FORGOTTENBOOKS';
        $options->interchangeSenderID = 'AMAZON';
        $options->applicationReceiverCode = 'FORGOTTEN_852';
        $options->applicationSenderCode = 'AMAZON';
        $options->ediReplySettings = new ReplySettings();
        $options->errorOnMissingPrice = true;

        // Setup the AfterProcess object
        $afterSendProcessing = new StoredProcedure();
        $afterSendProcessing->storedProcedureName = '';

        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->filePath = '';


        $ediType = EdiTypes::find(3); //   findOrFail($edi_type_id);
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 3;
        }
        $ediType->edt_name = 'Read 852 Sales Report';
        $ediType->edt_is_incoming = 1;
        #ediType->edt_edi_standard = 'X12';
        $ediType->edt_transaction_set_name = '852';
        $ediType->edt_enabled = 1;
        $ediType->edt_file_directory = '';
        $ediType->edt_edi_object =  serialize($options);
        $ediType->interchange_sender_id = 'AMAZON';
        $ediType->interchange_receiver_id = 'FORGOTTENBOOKS';
        $ediType->application_sender_code = 'AMAZON';
        $ediType->application_receiver_code = 'FORGOTTEN_852';
        // specific to this object
        $ediType->edt_before_process_object = serialize($beforeProcessObject);
        $ediType->edt_after_process_object = serialize($afterSendProcessing);
        $ediType->edt_transmission_object = '';
        $ediType->edt_file_drop = serialize($fileDrop);

        $ediType->save();


        /*
         \DB::table('edi_types')->insert([

         // normal property settings
         'id' => 3,
         'edtEDIType' => 'Read852SalesReport',
         'edtInOrOut' => '1',
         'edtedgID' => '852',
         'edtEnabled' => 1,
         'edtFileDirectory' => '',
         'edtObjectProperties' =>  serialize($options),
         'InterchangeSenderID' => 'AMAZON',
         'InterchangeReceiverID' => 'FORGOTTENBOOKS',
         'ApplicationSenderCode' => 'AMAZON',
         'ApplicationReceiverCode' => 'FORGOTTEN_852',
         // specific to this object
         'edtBeforeProcessObjectType' => 10,
         'edtBeforeProcessObject' => serialize($beforeProcessObject),
         'edtAfterSendProcessingType' => 11


         ]);
         */

    }
}

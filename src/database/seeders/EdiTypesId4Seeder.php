<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\EdiLaravel\FileHandling\FileFromDirectory;
use Bgies\EdiLaravel\FileHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Models\EdiTypes;

use Bgies\EdiLaravel\Lib\X12\ReplySettings;


class EdiTypesId4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setup the preProcess object
        $beforeProcessObject = new StoredProcedure();
        $beforeProcessObject->storedProcedureName = 'proc_get_856_to_send';
        

        // Setup the main Options object
        $options = new \Bgies\EdiLaravel\Lib\X12\Options\Send\Send856Options();
        $options->ediVersionReleaseCode = '5010';
        $options->ediVersionReleaseCodeExtended = '00501';
        $options->fileDirection = 'outgoing'; // Must be null, incoming or outgoing.. NOTHING ELSE
        
        $options->dataInterchangeControlNumber = 1;
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverID = 'AMAZON';
        $options->interchangeSenderID = 'FORGOT_US';
        $options->applicationReceiverCode = 'AMAZON';
        $options->applicationSenderCode = 'FORGOT_856';
        $options->GSFunctionalIdentifierCode = 'SH';
        $options->ediReplySettings = new ReplySettings();

        $options->transactionSetIdentifier = '856';
        $options->detailProcNameAndParams = 'proc_get_856_details :purchase_order_id';
        $options->hierarchicalStructureCode ='0001'; 
        $options->transactionSetPurposeCode = '00';
        $options->use4DigitYear = true;
        $options->useXDigitsFromControlNumber = 5;
        $options->isTestFile = false;
        
        

        // Setup the AfterProcess object
        $afterSendProcessing = new StoredProcedure();
        $afterSendProcessing->storedProcedureName = 'proc_856_after_process';

        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->filePath = '';


        $ediType = EdiTypes::find(4); //   findOrFail($edi_type_id);
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 4;
        }
        
        $ediType->edt_name = 'Send 856 ASN';
        $ediType->edt_is_incoming = 1;
        $ediType->edt_edi_standard = 'X12';
        $ediType->edt_transaction_set_name = '856';
        $ediType->edt_enabled = 1;
        $ediType->edt_file_directory = '';
        $ediType->edt_edi_object =  serialize($options);
        $ediType->interchange_sender_id = $options->interchangeSenderID;
        $ediType->interchange_receiver_id = $options->interchangeReceiverID;
        $ediType->application_sender_code = 'FORGOTTEN_856';
        $ediType->application_receiver_code = 'AMAZON';
        // specific to this object
        $ediType->edt_before_process_object = serialize($beforeProcessObject);
        $ediType->edt_after_process_object = serialize($afterSendProcessing);
        $ediType->edt_transmission_object = '';
        $ediType->edt_file_drop = serialize($fileDrop);

        $ediType->save();


    }
}

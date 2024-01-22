<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\EdiLaravel\FileHandling\FileFromDirectory;
use Bgies\EdiLaravel\FileHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Models\EdiTypes;

use Bgies\EdiLaravel\Lib\X12\ReplySettings;


class EdiTypesId7Seeder extends Seeder
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
        $beforeProcessObject->directoryName = 'outgoing/Send810Invoice';

        // Setup the main Options object
        $options = new \Bgies\EdiLaravel\Lib\X12\Options\Read\Read997Options();
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverID = 'AMAZON';
        $options->interchangeSenderID = 'FORGOTTENBOOKS';
        $options->applicationReceiverCode = 'AMAZON';
        $options->applicationSenderCode = 'FORGOTTEN_810';
        $options->ediReplySettings = new ReplySettings();        
//        $options->errorOnMissingPrice = true;
        
        // Setup the AfterProcess object
        $afterSendProcessing = new \Bgies\EdiLaravel\DataHandling\StoredProcedureMasterDetail();
        $afterSendProcessing->masterProcedure = 'proc_insert_810_entry :GroupControlNumber :NumberOfTransactionSetsIncluded :NumberOfReceivedTransactionSets :NumberOfAcceptedTransactionSets :Date ';
        $afterSendProcessing->detailProcedure = 'proc_insert_810_detail';

        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->filePath = '';


        $ediType = EdiTypes::find(7); //   findOrFail($edi_type_id);
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 7;
        }
        $ediType->edt_name = 'Send 810 Invoice';
        $ediType->edt_is_incoming = 2;
        $ediType->edt_edi_standard = 'X12';
        $ediType->edt_transaction_set_name = '810';
        $ediType->edt_enabled = 1;
        $ediType->edt_file_directory = '';
        $ediType->edt_edi_object =  serialize($options);
        $ediType->interchange_sender_id = 'FORGOT';
        $ediType->interchange_receiver_id = 'AMAZON';
        $ediType->application_sender_code = 'FORGOT_810';
        $ediType->application_receiver_code = 'AMAZON_810';
        $ediType->edt_alert_object = 1;
        // specific to this object
        $ediType->edt_before_process_object = serialize($beforeProcessObject);
        $ediType->edt_after_process_object = serialize($afterSendProcessing);
        $ediType->edt_file_drop = serialize($fileDrop);

        $ediType->save();


    }
}

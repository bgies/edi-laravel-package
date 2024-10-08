<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\EdiLaravel\FileHandling\FileFromDirectory;
use Bgies\EdiLaravel\DataHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Models\EdiTypes;

use Bgies\EdiLaravel\Lib\X12\ReplySettings;


class EdiTypesId6Seeder extends Seeder
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
        $beforeProcessObject->directoryName = 'incoming/Read856Replies997';

        // Setup the main Options object
        $options = new \Bgies\EdiLaravel\Lib\X12\Options\Read\Read997Options();
        $options->ediTypeId = 6;
        $options->fileDirection = 'incoming';
        $options->interchangeReceiverID = 'FORGOT_997';
        $options->interchangeSenderID = 'AMAZON_ID';
        $options->applicationReceiverCode = 'FORGOT_856';
        $options->applicationSenderCode = 'AMAZON_CODE';
        $options->ediReplySettings = new ReplySettings();        
        
        // Setup the AfterProcess object
        $afterSendProcessing = new \Bgies\EdiLaravel\DataHandling\StoredProcedureMasterDetail();
        $afterSendProcessing->masterProcedure = 'proc_insert_997_replies :GroupControlNumber :NumberOfTransactionSetsIncluded :NumberOfReceivedTransactionSets :NumberOfAcceptedTransactionSets :Date ';
        $afterSendProcessing->detailProcedure = 'proc_insert_997_detail_replies';

        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->moveFilesToDisk = 'edi';

        $ediType = EdiTypes::find(6); //   findOrFail($edi_type_id);
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 6;
        }
        $ediType->edt_name = 'Read 856 Replies 997';
        $ediType->edt_is_incoming = 1;
        $ediType->edt_edi_standard = 'X12';
        $ediType->edt_transaction_set_name = 997;
        $ediType->edt_enabled = 1;
        $ediType->edt_file_directory = '';
        $ediType->edt_edi_object =  serialize($options);
        $ediType->interchange_sender_id = 'AMAZON_ID';
        $ediType->interchange_receiver_id = 'FORGOT_ID';
        $ediType->application_sender_code = 'AMAZON_CODE';
        $ediType->application_receiver_code = 'FORGOT_856';
        $ediType->edt_alert_object = null;
        // specific to this object
        $ediType->edt_before_process_object = serialize($beforeProcessObject);
        $ediType->edt_after_process_object = serialize($afterSendProcessing);
        
        $ediType->edt_transmission_object = '';
        $ediType->edt_file_drop = serialize($fileDrop);

        $ediType->save();


    }
}

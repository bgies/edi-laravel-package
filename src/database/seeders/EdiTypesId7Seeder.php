<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\Phpedi\FileHandling\FileFromDirectory;
use Bgies\Phpedi\FileHandling\StoredProcedure;
use Bgies\Phpedi\FileHandling\FileDrop;
use Bgies\Phpedi\Models\EdiTypes;

use Bgies\Phpedi\lib\X12\Options\ReplySettings;


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
        $options = new \Bgies\Phpedi\lib\X12\Options\Read997Options();
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverID = 'AMAZON';
        $options->interchangeSenderID = 'FORGOTTENBOOKS';
        $options->applicationReceiverCode = 'AMAZON';
        $options->applicationSenderCode = 'FORGOTTEN_810';
        $options->ediReplySettings = new ReplySettings();        
//        $options->errorOnMissingPrice = true;
        
        // Setup the AfterProcess object
        $afterSendProcessing = new \Bgies\Phpedi\DataHandling\SPMasterDetail();
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
        $ediType->edtEDIType = 'Send810Invoice';
        $ediType->edtInOrOut = 2;
        $ediType->edtedgID = 810;
        $ediType->edtEnabled = 1;
        $ediType->edtFileDirectory = '';
        $ediType->edtObjectProperties =  serialize($options);
        $ediType->InterchangeSenderID = 'FORGOTTENBOOKS';
        $ediType->InterchangeReceiverID = 'AMAZON';
        $ediType->ApplicationSenderCode = 'FORGOTTEN_810';
        $ediType->ApplicationReceiverCode = 'AMAZON';
        $ediType->edtAlertEmails = 1;
        // specific to this object
        $ediType->edtBeforeProcessObjectType = 10;
        $ediType->edtBeforeProcessObjectProperties = serialize($beforeProcessObject);
        $ediType->edtAfterSendProcessingType = 12;
        $ediType->edtAfterSendProcessing = serialize($afterSendProcessing);
        $ediType->edtTransmissionProperties = '';
        $ediType->edtFileDropProperties = serialize($fileDrop);

        $ediType->save();


    }
}

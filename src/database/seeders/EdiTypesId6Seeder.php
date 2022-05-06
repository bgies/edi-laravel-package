<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\Phpedi\FileHandling\FileFromDirectory;
use Bgies\Phpedi\FileHandling\StoredProcedure;
use Bgies\Phpedi\FileHandling\FileDrop;
use Bgies\Phpedi\Models\EdiTypes;

use Bgies\Phpedi\lib\X12\Options\ReplySettings;


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
        $options = new \Bgies\Phpedi\lib\X12\Options\Read997Options();
        $options->fileDirection = 'incoming';
        $options->interchangeReceiverID = 'FORGOTTENBOOKS';
        $options->interchangeSenderID = 'AMAZON';
        $options->applicationReceiverCode = 'FORGOTTEN_856';
        $options->applicationSenderCode = 'AMAZON';
        $options->ediReplySettings = new ReplySettings();        
        $options->errorOnMissingPrice = true;
        
        // Setup the AfterProcess object
        $afterSendProcessing = new \Bgies\Phpedi\DataHandling\SPMasterDetail();
        $afterSendProcessing->masterProcedure = 'proc_insert_997_replies :GroupControlNumber :NumberOfTransactionSetsIncluded :NumberOfReceivedTransactionSets :NumberOfAcceptedTransactionSets :Date ';
        $afterSendProcessing->detailProcedure = 'proc_insert_997_detail_replies';

        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->filePath = '';

        $ediType = EdiTypes::find(6); //   findOrFail($edi_type_id);
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 6;
        }
        $ediType->edtEDIType = 'Read856Replies997';
        $ediType->edtInOrOut = 1;
        $ediType->edtedgID = 997;
        $ediType->edtEnabled = 1;
        $ediType->edtFileDirectory = '';
        $ediType->edtObjectProperties =  serialize($options);
        $ediType->InterchangeSenderID = 'AMAZON';
        $ediType->InterchangeReceiverID = 'FORGOTTENBOOKS';
        $ediType->ApplicationSenderCode = 'AMAZON';
        $ediType->ApplicationReceiverCode = 'FORGOTTEN_856';
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

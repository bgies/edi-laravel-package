<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\Phpedi\FileHandling\FileFromDirectory;
use Bgies\Phpedi\FileHandling\StoredProcedure;
use Bgies\Phpedi\FileHandling\FileDrop;
use Bgies\Phpedi\Models\EdiTypes;

use Bgies\Phpedi\lib\X12\Options\ReplySettings;


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
        $options = new \Bgies\Phpedi\lib\X12\Options\Send856Options();
        $options->ediVersionReleaseCode = '5010';
        $options->ediVersionReleaseCodeExtended = '00501';
        $options->fileDirection = 'outgoing'; // Must be null, incoming or outgoing.. NOTHING ELSE
        
        $options->dataInterchangeControlNumber = 1;
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverID = 'AMAZON';
        $options->interchangeSenderID = 'FORGOTTENBOOKS';
        $options->applicationReceiverCode = 'AMAZON';
        $options->applicationSenderCode = 'FORGOTTEN_856';
        $options->GSFunctionalIdentifierCode = 'SH';
        $options->ediReplySettings = new ReplySettings();
        $options->errorOnMissingPrice = true;
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
        $ediType->edtEDIType = 'Send856ASN';
        $ediType->edtInOrOut = 1;
        $ediType->edtedgID = 856;
        $ediType->edtEnabled = 1;
        $ediType->edtFileDirectory = '';
        $ediType->edtObjectProperties =  serialize($options);
        $ediType->InterchangeSenderID = 'FORGOTTENBOOKS';
        $ediType->InterchangeReceiverID = 'AMAZON';
        $ediType->ApplicationSenderCode = 'FORGOTTEN_856';
        $ediType->ApplicationReceiverCode = 'AMAZON';
        $ediType->edtControlNumber = 1;
        // specific to this object
        $ediType->edtBeforeProcessObjectType = 11;
        $ediType->edtBeforeProcessObjectProperties = serialize($beforeProcessObject);
        $ediType->edtAfterSendProcessingType = 11;
        $ediType->edtAfterSendProcessing = serialize($afterSendProcessing);
        $ediType->edtTransmissionProperties = '';
        $ediType->edtFileDropProperties = serialize($fileDrop);

        $ediType->save();


    }
}

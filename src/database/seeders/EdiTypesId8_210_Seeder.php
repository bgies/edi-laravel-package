<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bgies\EdiLaravel\Lib\X12\ReplySettings;
use Bgies\EdiLaravel\FileHandling\FileFromDirectory;
use Bgies\EdiLaravel\DataHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Models\EdiTypes;



class EdiTypesId8_210_Seeder extends Seeder
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
       $beforeProcessObject->storedProcedureName = 'proc_test_210';
        
        // Setup the main Options object
        $options = new \Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options();
        $options->ediId = 8;
        $options->fileDirection = 'outgoing';
        $options->interchangeReceiverQualifier = 'ZZ';
        $options->interchangeReceiverID = 'AMAZON';        
        $options->interchangeSenderQualifier = 'ZZ';
        $options->interchangeSenderID = 'FORGOT';
        $options->applicationReceiverCode = 'AMAZONREC';
        $options->applicationSenderCode = 'FORGOT_210';
        $options->interchangeControlVersionNumber = '00401';
        $options->responsibleAgencyCode = 'X';
        $options->useDetailQuery = 1;
        $options->detailSQL = 'proc_test_210_detail';
        
        $options->transactionSetIdentifier = '210';
        $options->transactionSetControlNumber = 0;
        $options->useXDigitsFromControlNumber = 6;
        $options->dataInterchangeControlNumber = 1;
        
        $options->B3Options = new \Bgies\EdiLaravel\Lib\X12\Options\Segments\B3Options();
        $options->Loop0100Options = new \Bgies\EdiLaravel\Lib\X12\Options\Segments\Seg210Loop0100();
        $options->Loop0100Options->LoopCount = 3;
        $options->Loop0100Options->MaxCount = 3;
        $options->Loop0100Options->UseN4 = true;
        
        $options->testFileOptions = new \Bgies\EdiLaravel\Lib\X12\Options\TestOptions\TestFile210();
        $options->testFileOptions->errorOnZeroInvoiceAmount = true;
        
        $options->N9Segments = 'BM:BillOfLading|CN:InvoiceNumber';
        $options->Loop0060ConvertValueToUpperCase = false;
        
        $options->UseR3Segment = false;
        $options->UseH3Segment = false;
        $options->UseK1Segment = false;

        $options->ErrorOnBlankLocationCode == false;
        //$this->ediOptions->detailSQL = 'proc_williams_210_detail :DetailFieldId';
        $options->writeOneLine = true;
        
        
        $options->ediReplySettings = new ReplySettings();        
//        $options->errorOnMissingPrice = true;
        $options->delimiters = new \Bgies\EdiLaravel\Lib\X12\Delimiters();

        // Setup the AfterProcess object
        $afterSendProcessing = new FileDrop();
        $afterSendProcessing->filePath = '';
        
        // Setup the FileDrop object
        $fileDrop = new FileDrop();
        $fileDrop->filePath = '';

        $transmissionObject = null; //new FTPS();

        

        $ediType = EdiTypes::find(8); 
        if (!$ediType) {
            $ediType = new EdiTypes();
            // we need to be able to set the id, so unguard the model.
            EdiTypes::unguard();
            $ediType->id = 8;
        }
  
        $ediType->edt_name = 'Send 210 Invoice';
        $ediType->edt_is_incoming = 2;
        $ediType->edt_edi_standard = 'X12';
        
        $ediType->edt_transaction_set_name = '210';
        $ediType->edt_enabled = 1;
        $ediType->edt_file_directory = '';
        $ediType->interchange_sender_id = 'FORGOT';
        $ediType->interchange_receiver_id = 'AMAZON';
        $ediType->application_sender_code = 'FORGOT_810';
        $ediType->application_receiver_code = 'AMAZON_810';
        $ediType->edt_alert_object = 1;
        // specific to this object
        
        $ediType->edt_edi_object = serialize($options);
        $ediType->edt_before_process_object = serialize($beforeProcessObject);
        $ediType->edt_after_process_object = serialize($afterSendProcessing);
        $ediType->edt_file_drop = serialize($fileDrop);
        $ediType->edt_transmission_object = null; //serialize($transmissionObject);
        
        $ediType->save();


        
        
        
        
        
    }
}

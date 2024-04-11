<?php

namespace Bgies\EdiLaravel\Lib;

use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\ReturnValues;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EdiReadOptions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;



class ReadEdiFile
{
   public int $ediFileId = 0;
   private $ediType = null;
   private $before_process_object = null;
   private $edi_options = null;
   private $data = null;
   private $after_process_object = null;
   private $ediFileDrop = null;

   /**
    * Create a new instance.
    *
    * @return void
    *
    * For now, I'm going to leave the construct method blank, but that
    * will change if I find a benefit to doing some of the setup in it.
    * So, I'll pass the EdiFileId to the construct method, set the variable,$this
    * and just ignore it for now.
    */
   
   public function __construct(int $ediFileId)
   {
      $this->ediFileId = $ediFileId;
   }
   
   
   /*
    * This method should get the contents of the file, read the ISA segment,
    * break the file into segments, pass that to the appropriate transaction set,
    * run the execute method of the transaction set, and make the entries into
    * the database
    * 
    */
   public function readFile() : ReturnValues {
      LoggingFunctions::logThis('info', 3, 'Bgies\EdiLaravel\Lib\readFile::runTransactionSet', 'ediFileId: ' . (string) $this->ediFileId);
      
      $retValues = new ReturnValues();
      
      $ediFile = EdiFile::find($this->ediFileId);
      
      // Need to read both the ISA and GS segments to set the 
      // application ID's and the Sender/Reciever ID's
      // The ReadX12FileIntoStrings
      $EDIObj = new EdiReadOptions();
      $filePath = env('EDI_TOP_DIRECTORY') . "/" . $ediFile->edf_filename;
      $sharedTypes = new SharedTypes();
      // $filePath = $ediFile->edf_filename; // for testing exceptions

      /*
       * this procedure reads the ISA, GS, and ST segments to set delimiters, dates
       * and sender/receiver id's  
       * 
       * NOTE we are using a default EDIObj here because we can't find the 
       * correct one until we can find the correct EDI Type, and we will 
       * use the Sender/Receiver ids plus the transaction set. 
       */
      $fileArray = EdiFileFunctions::ReadX12FileIntoStrings($filePath, $EDIObj, false, $sharedTypes);
      // now we need to check to make sure we have this edi type.
      $ediType = EdiType::where('edt_edi_standard', '=', 'X12')
         ->where('interchange_sender_id', '=', $EDIObj->interchangeSenderID)
                     ->where('interchange_receiver_id', '=', $EDIObj->interchangeReceiverID)
                     ->where('application_sender_code', '=', $EDIObj->applicationSenderCode)
                     ->where('application_receiver_code', '=', $EDIObj->applicationReceiverCode)
                     ->get();
                     
      if ($ediType->count() == 0) {
         throw new EdiFatalException('No EDI Type in the database matches this file');
      }
                     
                     
                     
      $lineCount = 0;
      
      
      
      
      
      
      
      return $retValues;
   }
   
}
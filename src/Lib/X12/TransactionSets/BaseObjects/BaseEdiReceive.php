<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;

use Illuminate\Database\Eloquent\Collection;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEDIObject;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;

use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Models\EdiFile;


abstract class BaseEdiReceive extends BaseEDIObject 
{
   protected $dataset = array();
   public $ediFile = null; // EdiFile is the one line string representation of the EDI File
   protected $ediTypeId = null;
   protected ?EdiType $ediType = null;
   public $ediOptions = null;
   protected $beforeProcessObject = null;
   protected $fileString = ''; // File String is the one line string representation of the EDI File
   protected $fileArray = array();  // FileArray is the EDI file broken into segments
   protected $afterProcessObject = null;
   
   
   protected $errorCount = 0;

   abstract protected function getFile() ;
   
   
   abstract protected function dealWithFile();

   
   protected function getEDIType(int $ediTypeId) { 
      
      
   }

   /*
    * The Master Dataset is a collection of the data required for each 
    * Transaction set. NOTE fields required for a particular Transaction
    * Set should be added to that Transaction Set.  
    */
   protected function getMasterDataset() : array {
      $record = array(
//         'InvoiceID' => null,
         'SegmentType' => null,
         'FunctionalIdentifierCode' => null,
         'GroupAcknowledgeCode' => null,
         'NumberOfTransactionSetsIncluded' => null,
         'NumberOfReceivedTransactionSets' => null,
         'NumberOfAcceptedTransactionSets' => null,
         'DataInterchangeControlNumber' => null,
         'InterchangeSenderID' => null,
         'InterchangeReceiverID' => null,
         'ApplicationSenderID' => null,
         'ApplicationReceiverID' => null,
         'DetailDataSet' => array()
      );
      
      return $record;
   }
   
   
   protected function getDetailDataset() {
      $record = array(
         'TransactionSetIdentifierCode' => null,
         'TransactionSetControlNumber' => null,
         'SetAcknowledgmentCodeSegment' => null,
         'TransactionSetNoteCode1' => null,
         'TransactionSetNoteCode2' => null,
         'TransactionSetNoteCode3' => null,
         'TransactionSetNoteCode4' => null,
         'TransactionSetNoteCode5' => null,
         'ErrorDescription' => null,
         'SegmentIDCode' => null,
         'SegmentPosition' => null,
         'LoopIdentifierCode' => null,
         'SegmentSyntaxErrorCode' => null
      );
      return $record;
   }
   
   
   
   
   protected function checkSenderReceiver(array  $fileArray, array $f, EDIReadOptions $EDIObj ) : bool
   {
      // just for debugging. 
      $isaSegment = $fileArray[0];
      $gsSegment = $fileArray[1];
      
      $isOk = true;
      
      if ($fileArray[0][6] != $EDIObj->interchangeSenderID) {
         $isOk = false;
         throw new EdiFatalException('Interchange Sender Id in the file does not match the EDI Type');
      }
      if ($fileArray[0][8] != $EDIObj->interchangeReceiverID) {
         $isOk = false;
         throw new EdiFatalException('Interchange Receiver Id in the file does not match the EDI Type');
      }
      if ($fileArray[1][2] != $EDIObj->applicationSenderCode) {
         $isOk = false;
         throw new EdiFatalException('Application Sender Code in the file does not match the EDI Type  File: ' .
            $fileArray[1][2] . '  EDI Type: ' . $EDIObj->applicationSenderCode);
      }
      if ($fileArray[1][3] != $EDIObj->applicationReceiverCode) {
         $isOk = false;
         throw new EdiFatalException('Application Receiver Code in the file does not match the EDI Type  File: ' .
            $fileArray[1][3] . '  EDI Type: ' . $EDIObj->applicationReceiverCode);
      }
      
      return $isOk;
   }
   
   public function setFileArray(array $array) {
      $this->fileArray = $array;
   }
   
   
   
   
   
   
   
}
   
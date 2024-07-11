<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;

use Illuminate\Database\Eloquent\Collection;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEDITransaction;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Models\EdiFile;


abstract class BaseEdiReceive extends BaseEDITransaction
{
   public $dataset = array();
   protected ?EdiFile $ediFile = null; 
   public $ediOptions = null;
   protected $beforeProcessObject = null;
   protected $fileString = ''; // File String is the one line string representation of the EDI File
   protected $fileArray = array();  // FileArray is the EDI file broken into segments
   protected string $fileContents = ''; // fileContentsis the one line string representation of the EDI File
   protected $filePath = '';
   protected $afterProcessObject = null;
   
   
   protected $errorCount = 0;

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(EdiType $ediType, EdiFile $ediFile)
   {
      parent::__construct($ediType);
      $this->ediFile = $ediFile;
      
   }
   
   
   abstract protected function getFile() ;
   
   
   abstract protected function dealWithData();

   
   abstract protected function setupDataSets();
   
      
   /*
    * The Master Dataset is a collection of the data required for each 
    * Transaction set. NOTE fields required for a particular Transaction
    * Set should be added to that Transaction Set.  
    */
   protected function getMasterDataset() : array {
      $record = array(
//         'InvoiceID' => null,
         'FunctionalIdentifierCode' => null,
         'GroupAcknowledgeCode' => null,
         'NumberOfTransactionSetsIncluded' => null,
         'NumberOfReceivedTransactionSets' => null,
         'NumberOfAcceptedTransactionSets' => null,
         'DataInterchangeControlNumber' => null,
         'InterchangeSenderID' => null,
         'InterchangeReceiverID' => null,
         'ApplicationSenderCode' => null,
         'ApplicationReceiverCode' => null,
         'DetailDataSet' => array()
      );
      
      return $record;
   }
   
   
   abstract protected function getDetailDataset() : array;
   
/*   
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
*/
   
   /*
    * This procedure checks to make sure the basic file segment counts
    * are correct. 
    */
   protected function checkFileCounts($fileArray, $EDIObj) : ReturnValues
   {
      $retVals = EdiFileFunctions::checkFileIntegrity($fileArray, $EDIObj);
      
      
      
   }
   
   /*
    * this procedure checks to make sure the segment count in an ST-SE group
    * is correct. The 
    * $stArrayPos must be the ST segment position in the File Array
    * NOTE this procedure ONLY checks one ST group, so needs to be called
    * once for every ST group in the file
    */
   protected function checkSTSEIntegrity(array $fileArray, int $stArrayPos) : ReturnValues
   {
      $retVals = new ReturnValues();
      $stSegment = $fileArray[$stArrayPos];
      $stSegmentArray = explode($this->ediOptions->delimiters->ElementDelimiter, $stSegment);
      if ($stSegmentArray[0] != 'ST') {
         throw new EdiFatalException('The parameters passed to checkSTSEIntegrity are not correct');
      }
      
      $stGroupCount = 1;
      for ($i = $stArrayPos; $i < count($fileArray); $i++) {
         $stGroupCount++;
         $curSegment = $fileArray[$stArrayPos + $i];
         $stCurSegmentArray = explode($this->ediOptions->delimiters->ElementDelimiter, $curSegment);
         if ($stCurSegmentArray[0] == 'SE') {
            if ($stCurSegmentArray[1] != $stGroupCount + 1) {
               throw new EdiFatalException('The segment count for the ST-SE(01) starting File Position ' . $stArrayPos . ' is not correct');
            }
            $i = count($fileArray);
         }
      }      
      $retVals->setResult(true);
      return $retVals;
   }
   
   //protected function checkSenderReceiver(array  $fileArray, EDIReadOptions $EDIObj ) : bool
   protected function checkSenderReceiver(array  $fileArray, $EDIObj ) : bool
   {       
      $isaSegment = $fileArray[0];
      $isaArray = explode($EDIObj->delimiters->ElementDelimiter, $isaSegment);
      
      $gsSegment = $fileArray[1];
      $gsArray = explode($EDIObj->delimiters->ElementDelimiter, $gsSegment);
      
      $isOk = true;
      
      if (trim($isaArray[6]) != trim($EDIObj->interchangeSenderID)) {
         $isOk = false;
         throw new EdiFatalException('Interchange Sender Id in the file does not match the EDI Type');
      }
      if (trim($isaArray[8]) != trim($EDIObj->interchangeReceiverID)) {
         $isOk = false;
         throw new EdiFatalException('Interchange Receiver Id in the file does not match the EDI Type');
      }
      if (trim($gsArray[2]) != trim($EDIObj->applicationSenderCode)) {
         $isOk = false;
         throw new EdiFatalException('Application Sender Code in the file does not match the EDI Type  File: ' .
            $fileArray[1][2] . '  EDI Type: ' . $EDIObj->applicationSenderCode);
      }
      if (trim($gsArray[3]) != trim($EDIObj->applicationReceiverCode)) {
         $isOk = false;
         throw new EdiFatalException('Application Receiver Code in the file does not match the EDI Type  File: ' .
            $fileArray[1][3] . '  EDI Type: ' . $EDIObj->applicationReceiverCode);
      }
      
      return $isOk;
   }
   
   
   
   
   
   public function setFileArray(array $array) {
      $this->fileArray = $array;
   }
   
   public function setFilePath(string $filePath) {
      $this->filePath = $filePath;
   }
   
   public function setEdiFile(EdiFile $ediFile) {
      $this->ediFile = $ediFile;
   }

   public function setEdiType(EdiType $ediType) {
      $this->ediType = $ediType;
   }
      
   public function setFileContents(string $fileContents) {
      $this->fileContents = $fileContents;
   }
   
   
   
}
   
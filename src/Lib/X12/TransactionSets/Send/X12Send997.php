<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\Send;

use Illuminate\Routing\Controller as BaseController;
//use Bgies\EdiLaravel\Lib\X12\BaseEDIReceive;
use App\Exceptions\EdiException;
use App\Exceptions\EdiFatalException;
use Bgies\EdiLaravel\Lib\x12\options\read\EDIReadOptions;
use Bgies\EdiLaravel\Lib\x12\options\read\Read997Options;
use Bgies\EdiLaravel\Lib\x12\BaseEDIReceive;
use function Opis\Closure\serialize;
use Bgies\EdiLaravel\Models\Editypes as ediType;
use Bgies\EdiLaravel\StoredProcedure;
use Bgies\EdiLaravel\FileDrop;
use Bgies\EdiLaravel\FileFromDirectory;
use function Opis\Closure\unserialize;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Functions\FileFunctions;
use Bgies\EdiLaravel\Functions\ReadFileFunctions;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions;
use Bgies\EdiLaravel\Models\Edifiles;
use Bgies\EdiLaravel\Lib\x12\objects\Delimiters;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Storage;
use Bgies\EdiLaravel\Lib\x12\SharedTypes;
use Bgies\EdiLaravel\Lib\x12\options\ReplySettings;
use Bgies\EdiLaravel\Models\Ediincoming;



class X12Send997 extends BaseEDISend
{
   private $dataset = array();
   
   protected $Model = null;
   
   private $ediTypeId = null;
   private $ediType = null;
   public $ediOptions = null;
   private $edtBeforeProcessObject = null;
   private $fileString = '';
   private $fileArray = array();
   private $edtAfterProcessObject = null;
   
   private $ediFile = array();
   
   
   private $errorCount = 0;
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(int $edi_type_id)
   {
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 construct');
      
      //$this->ediTypeId = $edi_type_id;
      //\Log::info('class X12Read997 construct $edi_type_id: ' . $edi_type_id);
      
      $this->ediType = Editype::find(2); //   findOrFail($edi_type_id);
      \Log::info('class X12Read997 edi_type: ' . print_r($this->ediType->getAttributes(), true));
      
      //$rowCount =
      //Illuminate\Database\Eloquent\Collection
      
      if (!$this->ediType) {
         \Log::error('class X12Read997 edi_type NOT FOUND');
         return 0;
      }
      
      $this->Model = new Edifiles();
      
      $ediTesting = ENV('EDI_TESTING', false);
      if ($ediTesting) {
         // create a default edt_before_process_object_properties if there isn't one
         // for now at least. Shouldn't need this in production
         // UNCOMMENT THE LINE BELOW TO CLEAR THE BEFORE PROCESS OBJECT AND RECREATE IT WITH UPDATED PROPERTIES
         //$this->ediType->edt_before_process_object_properties = '';
         if ($this->ediType->edt_before_process_object_properties == '') {
            \Log::info('class X12Read997 edt_before_process_object_properties IS BLANK');
         
            switch($this->ediType->edt_before_process_object_type) {
               case 1: {    break; }
            
            
               case 8: {
                  $this->edtBeforeProcessObject = new FileDrop();
                  $this->edtBeforeProcessObject->fileDirectory = 'incoming';
                  break;
               }
               case 9: {
               
                  break;
               }
               case 10: {
                  $this->edtBeforeProcessObject = new FileFromDirectory();
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'Williams210Replies';
               
               break;
               }
               case 11: {
                  $this->edtBeforeProcessObject = new StoredProcedure();
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'Williams210Replies';
                  $this->edtBeforeProcessObject->storedProcedureName = 'proc_get_997_replies';
               
               }
               default: {
               
               }
            }
            $this->ediType->edt_before_process_object_properties = serialize($this->edtBeforeProcessObject);
            $this->ediType->save();
         
         } else {
            $this->edt_before_process_object_properties = serialize($this->ediType->edt_before_process_object_properties);
         }
         
         if ($this->ediType->edt_edi_object == '') {
            \Log::info('class X12Read997 edt_edi_object IS BLANK');
         
            $this->ediOptions = new Read997Options();
         
            $this->ediType->edt_edi_object = serialize($this->ediOptions);
            $this->ediType->save();
         } else {
            $this->ediOptions = unserialize($this->ediType->edt_edi_object);
         }
         
         if ($this->ediType->edt_after_process_object_properties == '') {
            \Log::info('class X12Read997 edt_after_process_object_properties IS BLANK');
         
            switch ($this->ediType->edt_after_process_object_type) {
               case 1:
                  $tempProperties = new FileDrop();
                  break;
               
               case 2:
               
                  break;
               
               //default:
            }
            $this->ediType->edt_after_process_object_properties = serialize($tempProperties);
            $this->ediType->save();
         }

      
      }  // END if ($ediTesting) {
      
      // NOTE - The actual object is at object_properties and the string representation is edt_edi_object
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->edtBeforeProcessObject = unserialize($this->ediType->edt_before_process_object_properties);
      $this->edtAfterProcessObject = unserialize($this->ediType->edt_after_process_object_properties);
      
      \Log::info('');
      \Log::info('class X12Read997 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;     
      
   
   }

   
   protected function checkSenderReceiver(EdiType $Model, array $f, EDIReadOptions $EDIObj ) : bool
   {
      $isaSegment = $Model[0];
      $gsSegment = $Model[1];
      
      $isOk = true;      
      
      if ($Model->interchange_sender_id != $EDIObj->interchangeSenderID) {
         $isOk = false;
         throw new EdiFatalException('Interchange Sender Id in the file does not match the EDI Type');
      }
      if ($Model->interchange_receiver_id != $EDIObj->interchangeReceiverID) {
         $isOk = false;
         throw new EdiFatalException('Interchange Receiver Id in the file does not match the EDI Type');
      }
      if ($Model->application_sender_code != $EDIObj->applicationSenderID) {
         $isOk = false;
         throw new EdiFatalException('Application Sender Code in the file does not match the EDI Type  Model: ' . 
            $Model->application_sender_code . '  File: ' . $EDIObj->applicationSenderID);
      }
      if ($Model->application_receiver_code != $EDIObj->applicationReceiverID) {
         $isOk = false;
         throw new EdiFatalException('Application Receiver Code Id in the file does not match the EDI Type  Model: ' . 
            $Model->application_receiver_code . '  File: ' . $EDIObj->applicationReceiverID);
      }
      
      return $isOk;
   }


   public function execute(): string
   {
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 execute START');
      

      if ($this->edtBeforeProcessObject) {
         $retFiles = $this->edtBeforeProcessObject->execute();
      } else {
         $retFiles = $this->getFile($this->ediOptions);
      }
      if (!$retFiles || count($retFiles) == 0) {
         return 'No Files to Process';
            //throw new EdiFatalException('No File found');
      }

      $sharedTypes = new SharedTypes();
      foreach ($retFiles as $curFile) {
         try {
            $filePath = env('EDI_TOP_DIRECTORY') . "/" . $curFile->einFileName;
            $fileArray = FileFunctions::ReadX12FileIntoStrings($filePath,
                  $this->ediOptions, false, $sharedTypes);
            $this->fileArray = $fileArray;
            $this->curFile = $curFile;
         
            $LineCount = 0;
//            SegmentFunctions::ReadISASegment($this->fileArray[0], $this->ediOptions, false,
//                  $LineCount);
               //\SegmentFunctions::ReadGSSegment();
         
            try {
               $this->checkSenderReceiver($this->ediType, $this->fileArray, $this->ediOptions);
            } catch (EdiFatalException $e) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute checkSenderReceiver aborting... File: ' . $filePath);
               throw($e);
            }
         
         } catch (EdiException $e) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in getData: ' . $e->message);
         } catch (Exception $e) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in getData: ' . $e->message());
         }
      
      
         try {
            // we've already read the ISA, GS and ST segments in the
            // ReadX12FileIntoStrings
            $FileLineCount = 3; 
            
            $retVal = $this->readFile($this->curFile, $this->fileArray, $this->ediOptions, $FileLineCount, $sharedTypes); 
            if (!$retVal) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute readFile Failed aborting...');
               return false;
            }
         } catch (EdiException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in composeFile: ' . $e->message);
            return print_r($this->ediOptions->ediMemo, true);
         }
      
         try {
            $retVal = $this->dealWithFile();
            if (!$retVal) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in dealWithFile');
               return print_r($this->ediOptions->ediMemo, true);
            }
            
         } catch (EdiException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in getData: ' . $e->message);
            return print_r($this->ediOptions->ediMemo);
            //return print_r($this->ediOptions->ediMemo, true)
         }
      
      };
      
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 execute END');
      return print_r($this->dataset, $retVal);
   }
   

   protected function getFile(Read997Options $EDIObj)
   {
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 getFile() START');
      
      $dataResults = '';
      try {
         if (!$this->edtBeforeProcessObject) {
           
            
           
           $dataResults = '';
         } else {
            $dataResults = $this->edtBeforeProcessObject->execute();
         }

         
         
      } catch (Exception $e) {
         \Log::error('Bgies\EdiLaravel\X12 X12Read997 getFile EXCEPTION: ' . $e->getMessage());
      }
      
      return $dataResults;
      
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 getFile() dataResults: ' . print_r($dataResults, true));
   }
   
   
   protected function getMasterDataset() : array {
      $record = array(
         'InvoiceID' => null,
         'SegmentType' => null,
         'FunctionalIdentifierCode' => null,
         'GroupAcknowledgeCode' => null,
         'NumberOfTransactionSetsIncluded' => null,
         'NumberOfReceivedTransactionSets' => null,
         'NumberOfAcceptedTransactionSets' => null,
         'DataInterchangeControlNumber' => null,
         'AK301' => null,
         'AK302' => null,
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
   
   
   protected function readFile($curFile, array $Memo, EDIReadOptions $EDIObj, int $FileLineCount, SharedTypes $sharedTypes )
   {
      $masterDataset = $this->getMasterDataset();
      array_push($this->dataset, $masterDataset);
      $this->dataset = $masterDataset;
     
      $detailDataset = array();
      $LineCount997 = 1;
      try {
         do {
            $FileLineCount++;
            $LineCount997++;
            $LineType = SegmentFunctions::GetSegmentType($Memo[$FileLineCount - 1], $EDIObj->delimiters, $sharedTypes);
            switch ($LineType) {
               case 'Invalid' : {
                  throw new EdiException('An invalid segment type was encountered in an EDI 997 segment. Aborting....');
                  break;
               }
               case 'ISA' : {
                  throw new EdiException('An ISA segment was encountered inside an EDI 997 segment. Aborting....');
                  break;
               }
               case 'ST'  : {
                  throw new EdiException('A 997 ST segment was not terminated with an SE segment');
                  break;
               }
               case 'IEA' : {
                  throw new EdiException('An IEA segment was encountered inside an EDI 997 segment. Aborting....');
                  break;
               }
               case 'SE'  : {
                  SegmentFunctions::ReadSESegment($Memo[$FileLineCount - 1], $EDIObj, $LineCount997);
                  break;
               }
               case 'AK1' : {
                  \Bgies\EdiLaravel\Functions\ReadFileFunctions::ReadAK1Line($Memo[$FileLineCount - 1], $EDIObj->delimiters, $masterDataset );
                  break;
               }
               case 'AK2' : {
                  $masterDataset['InterchangeSenderID'] = $EDIObj->interchangeSenderID;
                  $masterDataset['InterchangeReceiverID'] = $EDIObj->interchangeReceiverID;
                  $detailDataset = $this->getDetailDataset();
                                     
                  $masterDataset['DetailDataSet'][count($masterDataset['DetailDataSet'])] = $detailDataset;
                  
                  ReadFileFunctions::ReadAK2Line($Memo[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK3' : {
                  ReadFileFunctions::ReadAK3Line($Memo[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }                
               case 'AK4' : {
                  ReadFileFunctions::ReadAK4Line($Memo[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK5' : {
                  ReadFileFunctions::ReadAK5Line($Memo[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK9'  : {
                  ReadFileFunctions::ReadAK9Line($Memo[$FileLineCount - 1],
                     $EDIObj->delimiters, $masterDataset);
                   break;
               }
      
               default : {

                  break;
               }
            }
               

         } while ($LineType != 'SE' && ($FileLineCount <= count($Memo)));
//         until (lineType = ltSE) or (FileLineCount >= Memo.Count);
       
         
         
      } catch (Exception $e) {
         throw($e);          
      }
      
      return true;
   }   
   
   // if Files can be updated, then update them, also need to put in 
   protected function dealWithFile()
   {
      $fullDataSet = $this->dataset;
      foreach ($fullDataSet['DetailDataSet'] as $curDetail ) {
              
            
            
      }         
         
         

      
      
      
      return true;
   }
   
   
   
   
}
<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\Read;

use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiReceive;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;

class X12Read210 extends BaseEdiReceive
{
   public $transactionSetName = '210';
   
   /*
    * From BaseEdiReceive
    *    protected $dataset = array();
    *    protected $ediTypeId = null;
    *    protected ?EdiType $ediType = null;
    *    protected $ediOptions = null;
    *    protected $edtBeforeProcessObject = null;
    *    protected $fileString = '';
    *    protected $fileArray = array();
    *    protected $edtAfterProcessObject = null;
    *    protected $errorCount = 0;
    */
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct($ediType)
   {
      parent::__construct($ediType->id);
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\ReadX12Send210 construct', 'edi_type_id: ' . $ediType->id);
     
      $this->ediType = $ediType;
      
      if (!$this->ediType) {
         LoggingFunctions::logThis('error',7, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type (' . $edi_type_id . ') NOT FOUND');
         return 0;
      }

      LoggingFunctions::logThis('info',3, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type: ' . print_r($this->ediType->getAttributes(), true));
      
      $this->ediFile = new EdiFile();
      
      /*
       * We shouldn't need this anymore, as we can now edit the edi_types table
       */
      /*
      $ediTesting = ENV('EDI_TESTING', false);
      if ($ediTesting) {
         // create a default edt_before_process_object_properties if there isn't one
         // for now at least. Shouldn't need this in production
         // UNCOMMENT THE LINE BELOW TO CLEAR THE BEFORE PROCESS OBJECT AND RECREATE IT WITH UPDATED PROPERTIES
         //$this->ediType->edt_before_process_object_properties = '';
         if ($this->ediType->edt_before_process_object_properties == '') {
            LoggingFunctions::logThis('info',6, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edt_before_process_object_properties IS BLANK');
            
            switch($this->ediType->edt_before_process_object) {
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
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'W210Replies';
                  
                  break;
               }
               case 11: {
                  $this->edtBeforeProcessObject = new StoredProcedure();
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'W210Replies';
                  $this->edtBeforeProcessObject->storedProcedureName = 'proc_get_210_replies';
                  
               }
               default: {
                  
               }
            }
            $this->ediType->edt_before_process_object = serialize($this->edtBeforeProcessObject);
            $this->ediType->save();
            
         } else {
            $this->edt_before_process_object = serialize($this->ediType->edt_before_process_object);
         }
         
         if ($this->ediType->edt_edi_object == '') {
            \Log::info('class X12Read997 edt_edi_object IS BLANK');
            
            $this->ediOptions = new Read210Options();
            
            $this->ediType->edt_edi_object = serialize($this->ediOptions);
            $this->ediType->save();
         } else {
            $this->ediOptions = unserialize($this->ediType->edt_edi_object);
         }
         
         if ($this->ediType->edt_after_process_object == '') {
            \Log::info('class X12Read210 edt_after_process_object IS BLANK');
            
            $tempProperties = new FileDrop();
            $this->ediType->edt_after_process_object = serialize($tempProperties);
            $this->ediType->save();
         }
         
         
      }  // END if ($ediTesting) 
      */
      
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->edtBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->edtAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      
      \Log::info('');
      \Log::info('class X12Read210 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
   }
   
   public function getFile()
   {
     
      
      
   }
   
   public function execute() : ReturnValues
   {
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\ReadX12Send210 execute', 'Start');
      $this->retValues = new ReturnValues();     
      
      /*
       *  if we already have a file to read, we can skip this 
       *  so we can manually read files 
       */
      if (count($this->fileArray) < 6) {
         if ($this->edtBeforeProcessObject) {
            $retFiles = $this->edtBeforeProcessObject->execute();
         } else {
            $retFiles = $this->getFile($this->ediOptions);
         }
         if (!$retFiles || count($retFiles) == 0) {
            LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\ReadX12Send210 execute', 'No Files to Process');
            $this->retValues->addToErrorList('No Files to Process');
            return $this->retValues;
         //throw new EdiFatalException('No File found');
         }
      } else {
         $retFiles[0] = $this->fileArray;
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
      
      
      
      
      
      
      return $this->retValues;
   }
   
   
   public function dealWithFile()
   {
      
      
      
   }
   
   
}
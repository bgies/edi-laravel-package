<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\Read;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiReceive;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;


class X12Read{{TransactionSetName}} extends BaseEdiReceive
{
   public $transactionSetName = '{{TransactionSetName}}';
   protected ?EdiFile $ediFile = null;
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(EdiType $ediType, EdiFile $ediFile)
   {
      parent::__construct($ediType, $ediFile);
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read{{TransactionSetName}} construct', 'edi_type id: ' . $ediType->id);
      
      if (!$this->ediType) {
         LoggingFunctions::logThis('error',7, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read{{TransactionSetName}} construct', 'edi_type is null');
         return 0;
      }
      
      LoggingFunctions::logThis('info',3, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type: ' . print_r($this->ediType->getAttributes(), true));
      
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->edtBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->edtAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      
      \Log::info('');
      \Log::info('class X12Read210 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
      
      
      
      
      
/*      
      THIS CODE WAS DEVELOPED TO ALLOW SOME TESTING BEFORE THE CREATE FROM STUB ROUTINES.
  
      $ediTesting = ENV('EDI_TESTING', false);
      if ($ediTesting) {
         // create a default edt_before_process_object_properties if there isn't one
         // for now at least. Shouldn't need this in production
         // UNCOMMENT THE LINE BELOW TO CLEAR THE BEFORE PROCESS OBJECT AND RECREATE IT WITH UPDATED PROPERTIES
         //$this->ediType->edt_before_process_object_properties = '';
         if ($this->ediType->edt_before_process_object_properties == '') {
            LoggingFunctions::logThis('info',6, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read{{TransactionSetName}} construct', 'edt_before_process_object_properties IS BLANK');
            
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
                  $this->edtBeforeProcessObject->storedProcedureName = 'proc_get_{{TransactionSetName}}_replies';
                  
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
            
            $this->ediOptions = new Read{{TransactionSetName}}Options();
            
            $this->ediType->edt_edi_object = serialize($this->ediOptions);
            $this->ediType->save();
         } else {
            $this->ediOptions = unserialize($this->ediType->edt_edi_object);
         }
         
         if ($this->ediType->edt_after_process_object == '') {
            \Log::info('class X12Read{{TransactionSetName}} edt_after_process_object IS BLANK');
            
            $tempProperties = new FileDrop();
            $this->ediType->edt_after_process_object = serialize($tempProperties);
            $this->ediType->save();
         }
         
         
      }  // END if ($ediTesting) 
      
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->edtBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->edtAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      
      \Log::info('');
      \Log::info('class X12Read{{TransactionSetName}} edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
*/      
   }
   
   
   
   
   
}
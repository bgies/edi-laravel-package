<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;

use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiObject as BaseEdiObject;
use Bgies\EdiLaravel\Lib\X12\Options\BaseEdiOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EdiSendOptions;
use Illuminate\Database\Eloquent\Collection;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;


abstract class BaseEdiSend extends BaseEdiObject 
{
   
 
   public function __construct(int $edi_type_id)
   {
      parent::__construct($edi_type_id);
      
   }
  
   
   protected function getData() {
      \Log::info('BaseEdiSend getData $edi_type_id: ' . $this->edi_type_id);
      
      $this->ediType = Editype::find($edi_type_id); //   findOrFail($edi_type_id);
      
      if (!$this->ediType) {
         \Log::error('BaseEdiSend getData edi_type ' . $this->edi_type_id . ' NOT FOUND');
         return 0;
         throw new Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException('X12Send210 edi_type ' . $edi_type_id . ' NOT FOUND');
         
         exit;
      }
      
      // make sure it's a 210, otherwise ABORT
      if ($this->ediType->edt_transaction_set_name != '210') {
         \Log::error('X12Send210 edi_type ' . $edi_type_id . ' is not a 210');
         return 0;
         throw new Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException('X12Send210 edi_type ' . $edi_type_id . ' NOT FOUND');
         
         exit;
         
      }
      
      
      // NOTE - The actual object is at ediOptions and the string representation is edt_edi_object
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      // the ediOption object will be passed to the EDI Objectd so set a couple
      // of properties on it from the EDI type so we don't have to pass the
      // model also.
      $this->ediOptions->ediId = $edi_type_id;
      $this->ediOptions->transactionSetIdentifier = '210';
      //$this->ediOptions->transaction_control_number = $this->ediType->edf_transaction_control_number;
      
      
      $this->ediBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->ediAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      $this->ediFileDrop = unserialize($this->ediType->edt_file_drop);
      
      
      
      \Log::info('');
      \Log::info('class X12Send210 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
      
      
      
      
      
   }
   
   abstract protected function composeFile($dataResults, string $tableName);
   
   abstract protected function dealWithFile(string $FileShortName, EDISendOptions $EDIObj);
   
   protected function getEDIType(int $ediTypeId) {
      
           
      
   }
   
   abstract protected function checkForRequiredFields();
   
   
}
<?php

namespace Bgies\EdiLaravel\Lib;

use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\ReturnValues;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;



class RunEdiType
{
   public int $ediTypeId = 0;
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
    * So, I'll pass the EdiTypeId to the construct method, set the variable,$this
    * and just ignore it for now. 
    */
   
   public function __construct(int $ediTypeId)
   {
      $this->ediTypeId = $ediTypeId;
   }
      
   
   /* 
    * We can add other functions that take different parameters 
    * (ediType Name for instance), and just find the EDI type Id
    * and call the run TransactionSet method 
    * 
    */

   // This method should get the EdiType (with the model),
   // unserialize everything then pass the Options object to the 
   // transaction set, make the database entries, and call the 
   // execute method. in other words, this is a generic method, 
   // to take care of all the mundane bookkeeping type stuff
   public function runTransactionSet(int $ediTypeId) {
      LoggingFunctions::logThis('info', 3, 'Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet', 'ediTypeId: ' . (string) $ediTypeId);

      $retValues = new ReturnValues();
      
      // First get the EdiType from the Database
      $this->ediType = EdiTypes::find($ediTypeId); //   findOrFail($edi_type_id);
      
      if (!$this->ediType) {
         LoggingFunctions::logThis('error', 10, 'Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet', 'edi_type ' . $ediTypeId . ' NOT FOUND');
         return 0;
         throw new Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException('Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet edi_type ' . $ediTypeId . ' NOT FOUND');
         exit;
      }
                   
      $ediTypeName = $this->ediType->edt_name;
      $transactionSetClass = "Bgies\EdiLaravel\Lib\\";
      
      try {
         $this->before_process_object = unserialize($this->ediType->edt_before_process_object);
         $this->data = $this->before_process_object->execute();
         
         $retValues->addToMessages('before_process_object returned : ' . count($this->data) . ' rows');
         LoggingFunctions::logThis('info', 7, 'Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet ', 'before_process_object returned : ' . count($this->data) . ' rows');
      } catch (Exception $e) {
         LoggingFunctions::logThis('error', 10, 'Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet', 'Exception in unserialize edt_before_process_object ');
         $retValues->addToErrorList('Exception in before_process_object for ' . $ediTypeName);
         exit;
      }
      
           
      /*
       * the TransactionSetClass is the class that is responsible for 
       * creating the EDI file. Basically, we pass the EDI Options object
       * and the data to the TransactionSetClass, and we should get an 
       * appropriate EDI file.  
       */
      // the directory separator is doubled here to prevent escaping
      $transactionSetClass = 'Bgies\\EdiLaravel\\Lib\\';
      switch ($this->ediType->edt_edi_standard) {
         
         case ($this->ediType->edt_edi_standard == 'X12') :
            if ($this->ediType->edt_is_incoming == 1) {
               $transactionSetClass .= 'X12\\TransactionSets\\Read\\X12Read';
            } else {
               $transactionSetClass .= 'X12\\TransactionSets\\Send\\X12Send';
            }
            $transactionSetClass .= $this->ediType->edt_transaction_set_name;
            break;
         case ($this->ediType->edt_edi_standard == 'EDIFACT') :
            if ($this->ediType->edt_is_incoming == 1) {
               $transactionSetClass .= 'Edifact\TransactionSets\Read\EdifactRead' . $ediType->edt_transaction_set_name;
            } else {
               $transactionSetClass .= 'Edifact\TransactionSets\Send\EdifactSend' . $ediType->edt_transaction_set_name;
            }
            $transactionSetClass .= $this->ediType->edt_transaction_set_name;
            break;
            
         default: {
            break;
         }
      }
      LoggingFunctions::logThis('info', 6, 'Bgies\EdiLaravel\Lib\RunEdiType::runTransactionSet', 'transactionSetClass: ' . $transactionSetClass );
      \Log::info('EdiTypesController createNewFiles transactionSetClass: ' . $transactionSetClass);
      
      // now unserialize the Options Object for this EDI Type
      $this->edi_options = unserialize($this->ediType->edt_edi_object);
      $this->edi_options->transaction_set_name = $this->ediType->edt_transaction_set_name;
      $this->after_process_object = unserialize($this->ediType->edt_after_process_object);
      
      
//      $path = base_path();
//      include ($path . 'packages\\')
//      use $transactionSetClass;
      $transactionSet = new $transactionSetClass($this->ediType);
      $transactionSet->setData($this->data);
      $transactionSet->setOptions($this->edi_options);
      $transactionSet->setEdiType($this->ediType);
      
//      $transactionSet = new \ReflectionClass($transactionSetClass($this->ediType, $this->edi_options, $this->data, $retValues));
      $ret = $transactionSet->execute($retValues);
      
      
      $this->after_process_object->execute($retValues);
      
   
      $this->ediFileDrop = unserialize($this->ediType->edt_file_drop);
      if (strlen($this->ediFileDrop->filePath) > 3) {
         this->ediFileDrop->execute();
      }
      
      
      return $retValues;
   }
   
}






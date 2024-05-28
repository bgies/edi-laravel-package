<?php

namespace Bgies\EdiLaravel\Functions;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Stubs\X12SendOptionsStub;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Doctrine\DBAL\ColumnCase;



class CreateFromStub 
{
   private string $ediStandard = '';
   private string $transactionSetName = '';
   private ?int $inIncoming = null; 
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(string $ediStandard, string $transactionSetName,
      int $isIncoming)
   {
      //parent::__construct();
      // construct the unique objects for this Option Object here
      // and set the default properties
      // such as $this->B3Options = new B3Options();
      $this->ediStandard = $ediStandard;
      $this->transactionSetName = $transactionSetName;
      $this->isIncoming = $isIncoming;
   }
   
   public function getSrcDirectory() {
      $topDirectory =  __DIR__ ;
      $srcDir = dirname($topDirectory, 2) . '/src';
      return $srcDir;
   }
   
   public function fillOptionObject($options, array $input, EdiType $ediType) {
      // SETUP some defaults
      $options->ediId = $ediType->id;
      $options->fileDirection = $input['edt_is_incoming'];
      $options->interchangeReceiverID = $input['interchange_receiver_id'];
      $options->interchangeSenderID = $input['interchange_sender_id'];
      $options->applicationReceiverCode = $input['application_receiver_code'];
      $options->applicationSenderCode = $input['application_sender_code'];
      
      // Remove this when I put javascript in to force the version to be 
      if (!array_key_exists('edi_version', $input)) {
         $input['edi_version'] = '4010';
      }
      switch ($input['edi_version']) {
         case '3020' : $options->interchangeControlVersionNumber = '00302'; break;
         case '3040' : $options->interchangeControlVersionNumber = '00304'; break;
         case '4010' : $options->interchangeControlVersionNumber = '00401'; break;
         case '4060' : $options->interchangeControlVersionNumber = '00406'; break;
         case '5010' : $options->interchangeControlVersionNumber = '00501'; break;
         case '6010' : $options->interchangeControlVersionNumber = '00601'; break;
      }
      
      
      $options->responsibleAgencyCode = 'X';
      $options->useDetailQuery = 0;
      $options->detailSQL = '';
      
      $options->transactionSetIdentifier = $input['edt_transaction_set_name'];
      $options->transactionSetControlNumber = 0;
      $options->useXDigitsFromControlNumber = 6;
      $options->dataInterchangeControlNumber = 1;
      
      $options->testFileOptions = new \Bgies\EdiLaravel\Lib\X12\Options\TestOptions\BaseTestOptions();
      $options->testFileOptions->sendTestFile = false;
      
      return $options;
   }
   
   /*
    * We need to instantiate the Options Object and return it so it can be 
    * serialized and saved with the EDI Type. If it doesn't
    * already exist, we need to create a default Options Object and return it. 
    */
   public function CreateOptionObject(array $input, EdiType $ediType) : object {
      // first check to see if the file exists

      // top directory gives us this directory Http/Controllers
      // so go up 2 directories to get the package src directory, and add the /Stubs.
      $srcDir = $this->getSrcDirectory();
      
      $stubsDir = $srcDir . '/Stubs/';
      
      if ($this->ediStandard == 'X12') {
         if ($this->isIncoming == 1) {
            // check to see if we already have an options object available
            $optionsDir = $srcDir . '/Lib/X12/Options/Read/';
            $fullNamespaceName = 'Bgies\EdiLaravel\Lib\X12\Options\Read\Read' . $this->transactionSetName . 'Options';
            $fullOptionsName = $optionsDir . 'Read' . $this->transactionSetName . 'Options.php';
            if (!file_exists($fullOptionsName)) {
               // if we don't have an available Options object, create one from a stub
               $messagesArray[] = 'Options Object was not found. A new Options Object descended from EdiReadOptions was created at ' . $fullOptionsName . ', but it needs programming to make it useful ';
               
               $stubFullName = $stubsDir . 'X12ReadOptionsStub.php';
               $stubFileContent = file_get_contents($stubFullName, true);
               $stubFileContent = str_replace('{{TransactionSetName}}', $this->transactionSetName, $stubFileContent);
               
               $result = file_put_contents($fullOptionsName, $stubFileContent);

               $options = new $fullNamespaceName();
               
               $options = $this->fillOptionObject($options, $input, $ediType);
               
            } else {
               $options = new $fullNamespaceName();
               $options = $this->fillOptionObject($options, $input, $ediType);
               
            }
            
            
         } else {
            $optionsDir = $srcDir . 'Lib/Edifact/Options/Send/';
            $transactionSetDir = $srcDir . 'Lib/Edifact/TransactionSets/Send/';
         }
         
      } elseif ($edt_edi_standard == 'EDIFACT') {
         // if it's not X12, it will be EDIFACT (at least for now)
         
      }
      
      
      return $options;
      
   }
   
   /*
    * if we already have a transaction set object for this EDI Type, we 
    * don't need to do anything except return a positive 
    */
   public function CreateTransactionSetObject(array $input, EdiType $ediType) : ReturnValues {
      $srcDir = $this->getSrcDirectory();
      $retValues = new ReturnValues();
         
      $stubsDir = $srcDir . '/Stubs/';
      
      switch ($this->ediStandard) {
         case 'X12' : 
            if ($this->isIncoming == 1) {
               $transactionSetDir = $srcDir . '/Lib/X12/TransactionSets/Read/';
               $fullTransactionSetPath = $transactionSetDir . 'X12Read' . $this->transactionSetName . '.php';
               if (!file_exists($fullTransactionSetPath)) {
                  // if we don't have an available Transaction Set object, create one from a stub
                  $retValues->addToMessages('Transaction Set Object was not found. A new Transaction Set Object descended from BaseEdiRecieve was created at ' . $fullTransactionSetPath . ', but it needs programming to make it useful ');
         
                  $stubFullName = $stubsDir . 'X12ReadTransactionSetStub.php';
                  $stubFileContent = file_get_contents($stubFullName, true);
                  $stubFileContent = str_replace('{{TransactionSetName}}', $this->transactionSetName, $stubFileContent);
               
                  $result = file_put_contents($fullTransactionSetPath, $stubFileContent);
               }
               $retValues->setResult(true);
            } else {
               $transactionSetDir = $srcDir . '/Lib/X12/TransactionSets/Send/';
               $fullTransactionSetPath = $transactionSetDir . 'X12Send' . $transactionSetName . '.php';
               if (!file_exists($fullTransactionSetPath)) {
                  $retValues->addToMessages('Transaction Set Object was not found. A new Transaction Set Object descended from BaseEdiRecieve was created at ' . $fullTransactionSetPath . ', but it needs programming to make it useful ');
               
               
               }
            
            }
            break;
         case 'EDIFACT' : 
            // do the EDIFACT stuff here. 
            
            
            break;
         default :
            $retValues->setResult(false);
            $retValues->addToErrorList('Unknown EDI Standard (' . $this->ediStandard . ')');
            
            break;
      }
         
         
      
      
      return $retValues;
   }
      
}
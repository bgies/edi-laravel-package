<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;

use Bgies\EdiLaravel\Lib\ReturnValues;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Models\EdiType;


abstract class BaseEdiTransaction
{
   protected ?ReturnValues $retValues = null;
   protected ?EdiType $ediType;
   protected ?int $ediTypeId = null;

   

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(EdiType $edi_type)
   {
      $this->ediType = $edi_type;
      // we used to pass only the EDI Type ID , so I'm keeping it 
      // until I'm sure removing it won't break anything
      $this->ediTypeId = $edi_type->id;      
   }
      
      
   /**
    * The stored procedure name for the Object.
    *
    * @var string|null
    */
   protected $procname;
   
   /**
    * The EDI option object for this EDI Type.
    *
    * @var Child of EdiBaseOption. This object contains ALL the options for this object
    */
   protected $ediOptions;
   
   
   
   
   abstract protected function execute() : ReturnValues; 
   
   
  
   
   
   
}


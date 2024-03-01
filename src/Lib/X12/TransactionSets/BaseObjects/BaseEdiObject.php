<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;



abstract class BaseEdiObject 
{
   public int $edi_type_id;

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(int $edi_type_id)
   {
      $this->edi_type_id = $edi_type_id;
   }
      
      
   /**
    * The connection name for the Object.
    *
    * @var string|null
    */
   protected $connection;
   
   /**
    * The stored procedure name for the Object.
    *
    * @var string|null
    */
   protected $procname;
   
   /**
    * The EDI option object for this EDI Type.
    *
    * @var Child of EDI base ooption. This object contains ALL the options for this object
    */
   protected $ediOptions;
   
   
   
   
   abstract protected function execute(&$retValues) : string; 
   
   
  
   
   
   
}


<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects;



abstract class BaseEdiObject 
{
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
   protected $EdiOptions;
   
   
   
   
   abstract protected function execute() : string; 
   
   
    
   
   
   
}


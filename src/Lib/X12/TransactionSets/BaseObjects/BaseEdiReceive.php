<?php

namespace Bgies\EdiLavavel\Lib\X12\TransactionSets\BaseObjects;

use Illuminate\Database\Eloquent\Collection;
use Bgies\EdiLavavel\Lib\X12\TransactionSets\BaseEDIObject;



abstract class BaseEdiReceive extends BaseEDIObject 
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
   

//   abstract protected function getFile() ;
   
   
//   abstract protected function readFile($dataResults);
   
   abstract protected function dealWithFile();
   
   protected function getEDIType(int $ediTypeId) { 
      
      
   }
   
  
   
   
   
   
   
   
}
   
<?php

namespace Bgies\Phpedi\lib\x12;

use Illuminate\Database\Eloquent\Collection;
use Bgies\Phpedi\lib\x12\BaseEDIObject;



abstract class BaseEDIReceive extends BaseEDIObject 
{
   

//   abstract protected function getFile() ;
   
   
//   abstract protected function readFile($dataResults);
   
   abstract protected function dealWithFile();
   
   protected function getEDIType(int $ediTypeId) { 
      
      
   }
   
  
   
   
   
   
   
   
}
   
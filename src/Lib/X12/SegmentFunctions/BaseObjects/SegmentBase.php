<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects;


use Bgies\EdiLaravel\Exceptions\EdiException;


class SegmentBase
{
   public $versions = array ();

   public function isVersionTested(string $inVersion) : bool
   {
      if (in_array($inVersion, $this->versions)) {
         return true;
      }
      return false;
   }
   
   
   


}
<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Segments;

use Bgies\EdiLaravel\Lib\X12\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;

class Seg210Loop0100 {
   
   public $MaxCount = 4;
   public $LoopCount = 4;
   public $AllowCanadianPostalCodesForZip = true;
   public $CleanMexicanZipCode = true;
   public $TruncateAddressAtSlash = false;
   public $UseCarrierCustomerCodeForPerformingCarrier = false;
   public $UseN1 = true;
   public $UseN2 = false;
   public $UseN3 = true;
   public $UseN4 = false;
   public $UseN9 = false; 
   
   
   
}







<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Segments;

use Bgies\EdiLaravel\Lib\PropertyType;

class B3Options {
   
   public bool $CleanUpBillofLading = false;
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {

      $CleanUpBillofLading = false;
   }
   
   
   public function getPropertyTypes() {
      $propTypes['CleanUpBillofLading'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      
      return $propTypes;
   }
   
   
}
<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\TestOptions;


use Bgies\EdiLaravel\Lib\X12\Options\BaseTestOptions;


class TestFile210 extends BaseTestOptions
{
   public $errorOnBlankLocationCode =true;
   public $errorOnBlankLocationAddress = true;
   
   public $errorOnNegativeInvoiceAmount = true;

   public $errorOnBlankInvoiceDate = true;
   public $errorOnZeroInvoiceAmount = true;

   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
      
      
   }
   
   
   public function getPropertyTypes() {
      $propTypes = parent::getPropertyTypes();
      
      $propTypes['errorOnBlankLocationCode'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['errorOnBlankLocationAddress'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      $propTypes['errorOnNegativeInvoiceAmount'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      $propTypes['errorOnBlankInvoiceDate'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );      
      $propTypes['errorOnZeroInvoiceAmount'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      
      return $propTypes;
   }
   
   
   
   
   
   
}
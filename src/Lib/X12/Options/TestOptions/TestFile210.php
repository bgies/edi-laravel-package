<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\TestOptions;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\X12\Options\TestOptions\BaseTestOptions;


class TestFile210 extends BaseTestOptions
{
   public $ErrorOnBlankLocationCode =true;
   public $ErrorOnBlankLocationAddress = true;
   
   public $ErrorOnNegativeInvoiceAmount = true;

   public $ErrorOnBlankInvoiceDate = true;
   public $ErrorOnZeroInvoiceAmount = true;

   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
   
   
      $errorOnZeroInvoiceAmount = true;
   }
   
   
   public function getPropertyTypes() {
      $propTypes = parent::getPropertyTypes();
      
      $propTypes['ErrorOnBlankLocationCode'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['ErrorOnBlankLocationAddress'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      $propTypes['ErrorOnNegativeInvoiceAmount'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      $propTypes['ErrorOnBlankInvoiceDate'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );      
      $propTypes['ErrorOnZeroInvoiceAmount'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      
      return $propTypes;
   }
   
   
   
   
   
   
}
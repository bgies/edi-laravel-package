<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Send;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;



class Send{{TransactionSetName}}Options extends EDISendOptions
{
   public $transactionSetName = '{{TransactionSetName}}';
   
   
   
   /*** Full definition of procedure*/
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
      // construct the unique objects for this Option Object here 
      // and set the default properties 
      // such as $this->B3Options = new B3Options();
      
      
   }
   
   public function getPropertyTypes() {
      $propTypes = parent::getPropertyTypes();
      
      $propTypes['transactionSetName'] = new PropertyType(
         'string', 0, 30, false, true, null, true, true
         );
      
   }
      
   
}
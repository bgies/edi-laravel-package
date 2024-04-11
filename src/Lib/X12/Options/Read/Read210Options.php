<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;



class Read210Options extends EDIReadOptions
{
   public $transactionSetName = '210';
   
   
   
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
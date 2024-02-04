<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\TestOptions;



class BaseTestOptions
{
   public $sendTestFile = false;
   public $makeEntriesInDatabase = false;
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //parent::__construct();
      
      
   }
   
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      
      $propTypes['sendTestFile'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['makeEntriesInDatabase'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
            
      return $propTypes;
   }
   
   
   
   
}
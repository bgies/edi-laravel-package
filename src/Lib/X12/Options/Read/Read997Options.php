<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\X12\Options\Read\EdiReadOptions;

class Read997Options extends EdiReadOptions
{
   
   public $pickUpFileDirectory = '';
   public $dropOffFileDirectory = '';
   public $use_include_path = false; // NOTE - this is the variable from file_get_contents
   

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
      
      //$this->needs997 = false;
      
   }
   
   public function getPropertyTypes() {
      $propTypes = parent::getPropertyTypes();
      
      $propTypes['pickUpFileDirectory'] = new PropertyType(
         'string', 0, 30, false, true, null, true, true
         );
      $propTypes['dropOffFileDirectory'] = new PropertyType(
         'string', 0, 30, false, true, null, true, true
         );
      $propTypes['use_include_path'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      return $propTypes;
   }
   
   
   
   
   
   
}
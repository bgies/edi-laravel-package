<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\X12\Options\BaseEdiOptions;
use Bgies\EdiLaravel\Lib\PropertyType;


class EDIReadOptions extends BaseEdiOptions
{
   public $clientFileFormat = '';
   public bool $needs990 = false;
   public bool $needs997 = false;
   
   
   
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
      
      $propTypes['clientFileFormat'] = new PropertyType(
         'string', 0, 30, false, true, null, true, true
         );
      $propTypes['needs990'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['needs997'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      
      
      return $propTypes;
   }
   
   
   
   
}
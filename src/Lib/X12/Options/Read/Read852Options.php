<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EdiReadOptions;


class Read852Options extends EdiReadOptions
{
   /**
    * 
    * @var unknown
    */
   public $delimiters = null; // Delimiters object; 
   
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
      return $propTypes;
   }
   
       
       
       
       
   
   
}
<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Send;

use Bgies\EdiLaravel\Lib\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;


class Send856Options extends EDISendOptions
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

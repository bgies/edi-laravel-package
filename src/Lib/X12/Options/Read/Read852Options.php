<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;


class Read852Options extends EDIReadOptions
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
   
   

   public function getJSONOptions () {
       
       
       
       
       
   }
   
}
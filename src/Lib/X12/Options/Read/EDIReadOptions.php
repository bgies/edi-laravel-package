<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Read;

use Bgies\EdiLaravel\Lib\X12\Options\BaseEdiOptions;

class EDIReadOptions extends BaseEdiOptions
{
   public $clientFileFormat = '';
   
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
      
      $this->needs997 = false;
      $this->needs990 = false;
            
   }
   
   
  
   
   
   
   
}
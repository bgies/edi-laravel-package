<?php

namespace Bgies\EdiLaravel\DataHandling;



class StoredProcedureMasterDetail 
{

   public $masterProcedure = '';
   public $detailProcedure = '';
   
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      
      
   }
   
  
   public function execute(): string
   {
      \Log::info('Bgies\EdiLaravel\DataHandling\StoredProcedureMasterDetail execute START');
      
      
   }
   
   
   
}
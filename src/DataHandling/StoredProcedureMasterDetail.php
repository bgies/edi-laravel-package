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
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      
      $propTypes['masterProcedure'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      $propTypes['detailProcedure'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      
      return $propTypes;
   }
   
   
   
}
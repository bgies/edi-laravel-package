<?php

namespace Bgies\EdiLaravel\DataHandling;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Exeptions\EdiDbException;
use Illuminate\Support\Facades\DB;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


class StoredProcedureMasterDetail 
{

   public string $masterProcedureName = '';
   public string $detailProcedureName = '';
   public bool $useSubDetail = false;
   public bool $subDetailProcedureName = '';
   public string $subDetailFieldNames = ''; // if there are multiple sub detail fields use : to separate
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      
      
   }
   
  
   public function execute($dataset = null): string
   {
      if (! $this->masterProcedureName) {
         throw new EdiDbException("Stored Procedure Name is Blank");
         return false;
      }
      
      \Log::info('Bgies\EdiLaravel\DataHandling\StoredProcedureMasterDetail execute START');
      
      $procNameStr = "CALL " . $this->masterProcedureName;
      // if there are no params
      if ( ! strpos($this->masterProcedureName, ':') > 0) {
         $dbResults = \DB::select( $procNameStr );
         return $dbResults;
      }
      
      // if there are params
      $paramVals = [];
      $procNameStr = "CALL " . substr($this->storedProcedureName, 0, strpos($this->storedProcedureName, ':')) . ' (' ;
      $Str = substr(trim($this->storedProcedureName), strpos($this->storedProcedureName, ':'));
      do {
         if (!strpos($Str, ' ')) {
            $paramName = substr($Str, 1);
            $Str = '';
            $procNameStr .= $dataset->$paramName;
            
         } else {
            $paramName = substr($Str, 1, strpos($Str, ' '));
            $Str = substr($Str, strpos($Str, ' ') + 1);
         }
         $paramVals[] = $dataset->$paramName;
         //          $procNameStr .= '? ';
      } while (strlen($Str) > 0);
      
      $procNameStr .= ')';
      $dbResults = \DB::select(\DB::raw( $procNameStr ));
      //      $dbResults = \DB::select(\DB::raw( $procNameStr ), $paramVals);
      
      return $dbResults;
      
   }
   
   public function getPropertyTypes() {
      // $propTypes = parent::getPropertyTypes();
      $propTypes = [];
      
      $propTypes['masterProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      $propTypes['detailProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      $propTypes['useSubDetail'] = new PropertyType(
         'bool', 0, 255, true, false, null, true, true, 'Use another loop to enter sub details'
         );
      $propTypes['subDetailProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure for sub Detail Loops'
         );
      $propTypes['subDetailFieldNames'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      
      
      return $propTypes;
   }
   
   
   
}
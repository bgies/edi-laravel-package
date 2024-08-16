<?php

namespace Bgies\EdiLaravel\DataHandling;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Exeptions\EdiDbException;
use Illuminate\Support\Facades\DB;
use Bgies\EdiLaravel\Functions\LoggingFunctions;

class StoredProcedure 
{
   public $storedProcedureName = '';
   
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      LoggingFunctions::logThis('info', 6, 'Bgies\EdiLaravel\DataHandling\StoredProcedure construct', 'storedProcedureName: ' . $this->storedProcedureName);
      
      //parent::__construct();
   }
   
   public function execute($dataset = null)
   {
      if (! $this->storedProcedureName) {
         throw new EdiDbException("Stored Procedure Name is Blank");
         return false;
      }
      
      \Log::info('class StoredProcedure execute storedProcedureName: ' . $this->storedProcedureName);
      $procNameStr = "CALL " . $this->storedProcedureName;
      // if there are no params 
      if ( ! strpos($this->storedProcedureName, ':') > 0) {
          //$dbResults = \DB::select(\DB::raw( $procNameStr . ';' ));
          //$dbResults = \DB::statement( $procNameStr );
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
      //$propTypes = parent::getPropertyTypes();
      
      
      $propTypes['storedProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      
      return $propTypes;
   }
   
   
}


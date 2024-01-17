<?php

namespace Bgies\EdiLaravel\FileHandling;

use Bgies\EdiLaravel\Lib\PropertyType;

class FTP 
{
   public $url;
   public $username = '';
   public $password;
   public $commands = [];
   
   public $renameFile = false;
 
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      \Log::info('class FTP construct');
      
      //parent::__construct();
      
      //\Log::info('class FTP construct after parent');
      
   }
   
   public function execute(array $params = null)
   {
      if (! $this->url) {
         //throw new \Exception("Stored Procedure Name is Blank");
         return false;
      }
   
      if ($params) {
         $procNameStr = "CALL " . $this->storedProcedureName;
         
         foreach ($params as $param) {
            $procNameStr .= '? ';
         }
         foreach ($params as $name => $value) {
            $procNameStr .=  $value . ' ';
         }
         
         $dbResults = \DB::select("CALL " . $procNameStr );
         
      } else {
         $dbResults = \DB::select("CALL " . $this->storedProcedureName );
      }
      //DB::select('EXEC my_stored_procedure ?,?,?',['var1','var2','var3']);
      //\Log::info('class Phpedi execute dbResults: ' . print_r($dbResults, true));
      
      return $dbResults;
   }
   

   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      
      $propTypes['url'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'FTP Component'
         );
      $propTypes['userName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'FTP Component'
         );
      $propTypes['password'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'FTP Component'
         );
      $propTypes['commands'] = new PropertyType(
         'array', 0, 255, true, false, null, true, true, 'FTP Component'
         );
      $propTypes['renameFile'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true, 'FTP Component'
         );
      
      return $propTypes;
   }
   
   
   
}


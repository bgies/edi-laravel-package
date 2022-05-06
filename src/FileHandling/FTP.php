<?php

namespace Bgies\EdiLaravel\FileHandling;



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
   
   
   
   
}


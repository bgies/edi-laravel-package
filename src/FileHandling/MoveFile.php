<?php

namespace Bgies\EdiLaravel\FileHandling;

use Bgies\EdiLaravel\Functions\FileFunctions;
use Bgies\EdiLaravel\Lib\PropertyType;

class MoveFile 
{
    public $fromDisk = '';
    public $fromTopDirectory = '';
    public $fromFile = '';
    
    public $toDisk = '';
    public $toTopDirectory = '';
   
    public $toFormat = '';
    public $deleteSourceFile = false;
    
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      \Log::info('class MoveFile construct');
   }
   
   public function execute($fromDisk, $fromTopDirectory, $fromFile, $toDisk,
            $toTopDirectory, $ediTypeName, $EDIID, $deleteSourceFile) {
                
        $fileContents = \Storage::disk($fromDisk)->get($fromTopDirectory . '/' . $fromFile);
        
        $shortFileName = FileFunctions::getShortFileName($ediTypeName, $EDIID);
        
        \Storage::disk($toDisk)->put($toTopDirectory . '/' . $shortFileName, $fileContents);
    
        
        if ($deleteSourceFile) {
            \Storage::disk($fromDisk)->delete($fromTopDirectory . '/' . $fromFile);
        }
        
        return true;
   }
   
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      public $ = '';
      public $ = '';
      public $ = '';
      
      public $ = '';
      public $ = '';
      
      public $ = '';
      public $deleteSourceFile = false;
      
      $propTypes['fromDisk'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Move File Component'
         );
      $propTypes['fromTopDirectory'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Move File Component'
         );
      $propTypes['fromFile'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'File Name'
         );
      $propTypes['toDisk'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'File Name'
         );
      $propTypes['toTopDirectory'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'File Name'
         );
      $propTypes['toFormat'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'File Name'
         );
      $propTypes['deleteSourceFile'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true, 'FTP Component'
         );
      
      return $propTypes;
   }
   
   
   
}






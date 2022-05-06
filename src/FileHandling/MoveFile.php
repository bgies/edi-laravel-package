<?php

namespace Bgies\EdiLaravel\FileHandling;



use Bgies\EdiLaravel\Functions\FileFunctions;

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
   
   
   
   
}






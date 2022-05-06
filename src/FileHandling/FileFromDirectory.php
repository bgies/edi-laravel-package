<?php

namespace Bgies\EdiLaravel\FileHandling;

use Illuminate\Support\Facades\Storage;

class FileFromDirectory 
{
   public $directoryName = '';
   public $fileName = '';
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      \Log::info('class FileFromDirectory construct');
      
      //parent::__construct();
      
      \Log::info('class Phpedi construct after parent');
      
   }
   
   public function execute() {
      // $path = Storage::disk('edi')->path($this->directoryName);
      $files = Storage::disk('edi')->files($this->directoryName); 
      if (env('EDI_TESTING')) {
          \Log::info('class FileFromDirectory execute filePath: ' .  Storage::disk('edi')->path($this->directoryName));
          
      }
      return $files;
   }
   
  
   
   
}


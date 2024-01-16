<?php

namespace Bgies\EdiLaravel\Functions;


use Illuminate\Support\Facades\Storage;


/**
 * @author bgies
 *
 */
class FileFunctions
{
   

   public static function getFileNames($fromDirectory) {
      $files = Storage::disk('diskName')->allFiles($fromDirectory);
      Storage::get('file.jpg');
      $fileNames = array_map(function($file){
         return basename($file); } // remove the folder name
         , $files);
      return $fileNames;
   }

   
   /**
    * Get all the files names from a directory
    */  
   public static function getFileNamesFromPackageDirectory($fromDirectory) {
      //$path = __DIR__;
      $path = dirname(__DIR__, 1) . '/FileHandling';
      $files = scandir($path);
      $fileNamesArray = [];
      foreach ($files as $file) {
         $filePath = $path . '/' . $file;
         if (is_file($filePath)) {
            $fileNamesArray[] = $file;
         }
      }
      return $fileNamesArray;      
/*      
      $fqcns = array();

      $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
      $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
      $fileNamesArray = iterator_to_array($phpFiles);
      
      //return $phpFiles;
      return $fileNamesArray;
*/      
   }
}
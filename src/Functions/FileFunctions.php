<?php

namespace Bgies\EdiLaravel\Functions;


use Illuminate\Support\Facades\Storage;


/**
 * @author bgies
 *
 *  NOTE - many of the functions were just copy and pasted from Delphi, and then 
 *  changed just enough to avoid errors when loading the page. Each of them needs
 *  full testing
 *  
 *  
 */

class FileFunctions
{
   
   public static function getDirectoryDateString() {
      return  substr(\Bgies\EdiLaravel\Functions\DateTimeFunctions::GetDateStr(now(),true), 0, 6);
   }
   

   
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
      $path = dirname(__DIR__, 1) . '/' . $fromDirectory;
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
   
   // NOTE - The short file name is what's stored in the edi_outgoing_files and edi_incoming_files Table
   public static function getShortFileName($ediTypeName, $EDIID) {
      $DirectoryDateString = FileFunctions::getDirectoryDateString();
      $ShortFileName = $ediTypeName . '/' . $DirectoryDateString . '/' . $EDIID . '.txt';
      return $ShortFileName;
   }
   
   
   public static function getFileName(int $EDIID, string $ediTypeName)
   {
      $TopDirectory = EdiFileFunctions::getTopDirectory('edi');
      
      $FTPFileName = $TopDirectory . '/' . FileFunctions::getShortFileName($ediTypeName, $EDIID) ;
      
      return $FTPFileName;
   }
   
   public static function getPackageDirectory() {
      $topDirectory =  __DIR__ ;
      $srcDir = dirname($topDirectory, 2) . '/src';
      return $srcDir;
   }
   
   
}
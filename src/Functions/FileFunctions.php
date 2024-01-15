<?php

namespace Bgies\EdiLaravel\Functions;


use Illuminate\Support\Facades\Storage;


public getFileNames($fromDirectory) {
   $files = Storage::disk('diskName')->allFiles($fromDirectory);
   Storage::get('file.jpg');
   $fileNames = array_map(function($file){
         return basename($file); // remove the folder name
      , $files);
   return $fileNames;
}
        
public getFileNamesFromDirectory($fromDirectory) {
   $path = __DIR__;
   $fqcns = array();

   $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
   $phpFiles = new RegexIterator($allFiles, '/\.php$/');
   return $phpFiles;
}
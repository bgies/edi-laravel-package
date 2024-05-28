<?php

namespace Bgies\EdiLaravel\Functions;




class ClassFunctions
{
   public static function getPackageSrcDirectory() {
      $topDirectory =  __DIR__ ;
      $srcDir = dirname($topDirectory, 2) . '/src';
      return $srcDir;
   }
   
   /*
    * Only Class names that start with Bgies/EdiLaravel should be passed to this function. 
    */
   public static function classNameToDirectoryPath($className) {
      $srcDir = ClassFunctions::getPackageSrcDirectory();
      // remove the Bgies/EdiLaravel
      if (strpos($className, 'Bgies') < 3) {
         // remove any slash characters at the beginning. 
         do {
            if (substr($className, 0, 1) == '\\' || substr($className, 0, 1) == '/') {
               $cleanedClassName = substr($className, 1);
            }
         } while (substr($className, 0, 1) == '\\' || substr($className, 0, 1) == '/');
         
         // if it's there it's at least 16 characters
         $cleanedClassName = substr($className, 16);
         
         do {
            if (substr($cleanedClassName, 0, 1) == '\\' || substr($cleanedClassName, 0, 1) == '/') {
               $cleanedClassName = substr($cleanedClassName, 1);
            }
         } while (substr($cleanedClassName, 0, 1) == '\\' || substr($cleanedClassName, 0, 1) == '/');
         
         // switch the slashes to forward slashes
         $cleanedClassName = str_replace('\\', '/', $cleanedClassName);
      }

      $fullPath = $srcDir . '/' . $cleanedClassName . '.php';
      
      
      return $fullPath;
   }
   
   public static function doesClassExist(string $className) {
      
      $retVal = class_exists($className, false);
      // I haven't been able to get class_exists to work, so I'll also 
      // check to see if the class file exists, if it does, we can infer the
      // class exists, if it doesn't we've got bigger problems :) 
      if (!$retVal) {
         $fullClassPath = ClassFunctions::classNameToDirectoryPath($className);
         $retVal = file_exists($fullClassPath);
      }
      
      return $retVal;
   }
   
   /*
    * $ediStandard is basically an enum X12, EDIFACT, or Others  FROM SharedTypes::EDIStandard
    * $fileDirection either incoming or outgoing FROM SharedTypes::EDIFileDirection
    * $ediTransactionSetName IE 210, 997,   FROM SharedTypes::X12TransactionSets or SharedTypes::EdifactTransactionSets
    */
   public static function getTransactionSetClassName($ediStandard, $fileDirection, $ediTransactionSetName): string
   {
      $transactionSetPath = 'Bgies\\EdiLaravel\\Lib\\';
      switch ($ediStandard) {
         case 'X12' : 
            $transactionSetPath .= 'X12\\TransactionSets\\';
            if ($fileDirection == 1 | $fileDirection == 'incoming') {
               $transactionSetPath .= 'Read\\X12Read' . $ediTransactionSetName;
            } else {
               $transactionSetPath .= 'Send\\X12Send' . $ediTransactionSetName;
            }
            
            break;
         case 'EDIFACT' : 
            $transactionSetPath .= 'Edifact\\TransactionSets\\';
            if ($fileDirection == 1 | $fileDirection == 'incoming') {
               $transactionSetPath .= 'Read\\X12Read' . $ediTransactionSetName;
            } else {
               $transactionSetPath .= 'Send\\X12Send' . $ediTransactionSetName;
            }
            
            
            break;
         default : 
            
            
            break;
      }
      
      
      
      
      return $transactionSetPath;
      
      
   }
   
   
}
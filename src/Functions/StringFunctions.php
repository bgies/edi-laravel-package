<?php

namespace Bgies\EdiLaravel\Functions;


class StringFunctions 
{


   public static function CleanString(string $InString, bool $RemoveSpaces): string
   {
      $i = 1;
      $InString = trim($InString);
      $retVal = '';
      while ($i <= strlen($InString)) {
         $ordVal = ord($InString[$i-1]);

         if ( ($ordVal >= 48 && $ordVal <= 57) || ($ordVal >= 65 && $ordVal <= 90) || ($ordVal >= 97 && $ordVal <= 122)  ) {
            if ($RemoveSpaces) {
               if ($InString[$i-1] != ' ') {
                  $retVal .= substr($InString, $i-1, 1); // . substr($InString, $i, 1);
               }
            } else {
               $retVal .= substr($InString, $i-1, 1); //. ' ' . substr($InString, $i, 1);
            }
         }
         $i++;
        
      }
      return $retVal;      
   }
   
   
   public static function CleanUpZipCode(string $zipCode) : string
   {
      $TempStr = '';
      $zipCode = trim($zipCode);
      // then remove all non integer characters.
      for ($i = 0; $i < strlen($zipCode); $i++) {
         $intVal = ord($zipCode[$i]);
         if ((ord($zipCode[$i]) >= 48) && (ord($zipCode[$i]) <= 58) ) {
            $TempStr .= $zipCode[$i];
         }
      }
      
      if (strlen($TempStr) < 6) {
         // send 99999 instead of blank because zip is required.
         if (strlen($TempStr) < 4) {
            $TempStr = '99999';
            return $TempStr;
            Exit;
         }
      }
      
      if (strlen($TempStr) > 9) {
         $TempStr = substr($TempStr, 0, 9);
      }
      
      return $TempStr;
   }
      
   
   
   public static function RemoveSpaceFromCanadianPostal($inZip) : string
   {
      // just trim it and if there is a space in the 4th spot then remove it.
      $InZip = trim($InZip);
      if (strpos($InZip, ' ') == 3) {
         $retVal = substr($InZip, 0, 3) . substr($InZip, 4, 3);
      } else {
         $retVal = $InZip;
      }

      return $retVal;
   }
   
   
   
}

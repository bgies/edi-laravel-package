<?php

namespace Bgies\EdiLaravel\Functions;




//use lib\x12\SharedTypes;


class CurrencyFunctions 
{
   
   public static function ConvertMoneyToCents(float $MoneyAsFloat) : string {
      $TempFloat = ($MoneyAsFloat + 0.0049999) * 100;
      $TempInt = Round($TempFloat);
      return (string) $TempInt;
   }
   
   public static function RemoveDecimals(float $MoneyAsFloat) : string {
      $strParts = explode('.', $MoneyAsFloat);
      return $strParts[0];
   }
    
   public static function RemoveCommas(float $MoneyAsFloat) : string {
      $strParts = str_replace(',', '', $MoneyAsFloat);
      return $strParts;
   }
   
   
   
   
   
   
   
}
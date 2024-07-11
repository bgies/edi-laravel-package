<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;
//use lib\x12\SharedTypes;


class DateTimeFunctions 
{
    
    public static function getDateFromStr($inStr, bool $use4Digit) {
        if ($use4Digit) {
            $date = Carbon::createFromFormat('YYYYMMDD', $inStr);
        } else {
            $date = Carbon::createFromFormat('YYMMDD', $inStr);
        }
    
        return $date;
    }
   
    
   public static function GetDateStr($inDate, bool $use4Digit) {
      $retVal = '';
      if (trim($inDate) == '') {
         return '';
      }
      
      if (gettype($inDate) != 'object') {
         $inDate = Carbon::parse($inDate);
      }
      
      $intYear = $inDate->year;
      if (!$use4Digit) {
         $intYear = substr($intYear, 2, 2);  
      }
      $strYear = str_pad((string)$intYear, 2, '0', STR_PAD_LEFT);
      
      $intMonth = $inDate->month;
      $strMonth = str_pad((string)$intMonth, 2, '0', STR_PAD_LEFT);
      
      $intDay = $inDate->day;
      $strDay = str_pad((string)$intDay, 2, '0', STR_PAD_LEFT);
      
      $retVal = $strYear .= $strMonth .= $strDay;
      return $retVal; 

   }
   
   public static function GetTimeStr($inDate, $maxCharacters = 4) {
      $retVal = '';

      if (trim($inDate) == '') {
          return '';
      }
      
      if (gettype($inDate) != 'object') {
          $inDate = Carbon::parse($inDate);
      }
      
      $intHour = $inDate->hour;
      $strHour = str_pad((string)$intHour, 2, '0', STR_PAD_LEFT);
      
      $intDay = $inDate->minute;
      $strDay = str_pad((string)$intDay, 2, '0', STR_PAD_LEFT);
      
      $retVal = $strHour .= $strDay;
      
      if ($maxCharacters >=6) {
         $intSecond = $inDate->second;
         $strSecond = str_pad((string)$intSecond, 2, '0', STR_PAD_LEFT);
         
         $retVal .= $strSecond;
         
         if ($maxCharacters >=8) {
            $intMilliseconds = $inDate->millisecond;
            $strMillisecond = str_pad((string)$intMilliseconds, 2, '0', STR_PAD_LEFT);
         
             $retVal .= $strMillisecond;
         }
      }
      
      return $retVal;
   }

   // ISO 8601 format 2012-04-23T18:25:43.511Z  Wikopedia has a good description
   public static function EdiDateAndTimeTo8601($ediDate, $ediTime) : string {
      
      
      return '';
   }
   
   public static function EdiDateToMySQLDate($inDate) {
      // $dateStr
       
       
       
        return $dateStr;       
   }
   

}
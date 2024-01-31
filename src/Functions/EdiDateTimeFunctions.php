<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;
//use lib\x12\SharedTypes;


class EdiDateTimeFunctions 
{
   
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
      
      $intHour = $inDate->hour;
      $strHour = str_pad((string)$intHour, 2, '0', STR_PAD_LEFT);
      
      $intDay = $inDate->minute;
      $strDay = str_pad((string)$intDay, 2, '0', STR_PAD_LEFT);
      
      $retVal = $strHour .= $strDay;
      
      if ($maxCharacters >=6) {
         $intSecond = $inDate->second;
         $strSecond = str_pad((string)$intSecond, 2, '0', STR_PAD_LEFT);
         
         $intMilliseconds = $inDate->millisecond;
         $strMillisecond = str_pad((string)$intMilliseconds, 2, '0', STR_PAD_LEFT);
         
         $retVal .= $strSecond . $strMillisecond;
      }
      
      return $retVal;
   }

/*//======================================================================
function GetDateStr(inDate : TDateTime; Use4DigitYear : boolean) : string;
var
  iYear, iDay, iMonth : word;
  sYear, sDay, sMonth : string;
begin
  Result := '';
  if inDate < 1000 then
    Exit;

  DecodeDate(inDate, iYear, iMonth, iDay);
  sYear := intToStr(iYear);
  if not Use4DigitYear then
    sYear := copy(sYear, 3, 2);

  sMonth := intToStr(iMonth);
  sDay := intToStr(iDay);

  GetDateStr := LeftPadStr(sYear, 2, '0') + LeftPadStr(sMonth, 2, '0') + LeftPadStr(sDay, 2, '0');
end;





//======================================================================
function GetTimeStr(inDate : TDateTime) : string;
var
  iHour, iMin, iSec, iMSec : word;
  sHour, SMin : string;
begin
  DecodeTime(inDate, iHour, iMin, iSec, iMSec);
  sHour := intToStr(iHour);
  sMin := intToStr(iMin);
  Result := LeftPadStr(sHour, 2, '0') + LeftPadStr(sMin, 2, '0');
end;


//======================================================================
function GetTimeStr(inDate : TDateTime; MaxCharacters : integer) : string;
var
  iHour, iMin, iSec, iMSec : word;
  sHour, SMin, sSec, sMSec : string;
begin
  DecodeTime(inDate, iHour, iMin, iSec, iMSec);
  sHour := intToStr(iHour);
  sMin := intToStr(iMin);
  Result := LeftPadStr(sHour, 2, '0') + LeftPadStr(sMin, 2, '0');
  if MaxCharacters >= 6 then
    begin
      sSec := IntToStr(iSec);
      sMSec := IntToStr(iMSec);
      Result := Result + LeftPadStr(sSec, 2, '0');
      if MaxCharacters >= 8 then
        Result := Result + LeftPadStr(copy(sMSec, 1, 2), 2, '0');
    end;

end;

*/
   
   
   
   
   
   

}
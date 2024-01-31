<?php

namespace Bgies\EdiLaravel\Functions;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\lib\x12\options\EDISendOptions;
use Bgies\EdiLaravel\lib\x12\options\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentFunctionsAtoM 
{
   
   public function CleanBillofLading(string $BillOfLading): string
   {
      $Result = $BillofLading;
      $i = 1;
      $BillofLading = trim($BillofLading);
/*      
      while ($i <= strlen($BillofLading) {
         if (! ($BillofLading[i] in [chr(48),chr(57), chr(65)..chr(90), chr(97)..chr(122)])) then
         begin
         Result := copy(BillofLading, 1, i-1);
         Exit;
         end;
         i := i + 1;
         end;
      
      end;
      }
*/      
       return $Result; 
   }
      
      
   public static function GetB3Line(EDISendOptions $EDIObj, $row) : string 
   {
      $TempStr = '';
      $TempBOLString = '';
      $B3_08CorrectionIndicator = '';

      $TempStr = 'B3' . $EDIObj->delimiters->ElementDelimiter;
      //$TempStr .= 'U' . $EDIObj->delimiters->ElementDelimiter;   // B3 01
      $TempStr .= $EDIObj->delimiters->ElementDelimiter;    // B3 01
   
      if ($row['InvoiceNumber'] == '') {
         throw new EdiException('Invoice Number of id ' . $row['id'] . ' is blank.');
      }
   
      if ($EDIObj->ConvertInvoiceNumberToUpperCase) {
         $TempStr .= strtoupper($row['InvoiceNumber']) . $EDIObj->delimiters->ElementDelimiter;   // B3 02
      } else {
         $TempStr .= $row['InvoiceNumber'] . $EDIObj->delimiters->ElementDelimiter;   // B3 02
      }
     
      if ($EDIObj->B3Options->CleanUpBillofLading) {
         $TempBOLString .= $CleanBillofLading($row['BillOfLading']);
         $TempStr .= $TempBOLString . $EDIObj->delimiters->ElementDelimiter; // B3 03
      } else {
         $TempStr .= $row['BillOfLading'] . $EDIObj->delimiters->ElementDelimiter; // B3 03
      }
         
      $TempStr .= $row['PaymentMethod'] . $EDIObj->delimiters->ElementDelimiter;   // B3 04
      // Datetime less than 1 is considered blank
      if ($row['InvoiceDate'] < 1) {
         if ($EDIObj->TestFile && $EDIObj->EDI210TestFile->ErrorOnBlankInvoiceDate) {
            throw new EdiException('The Invoice Date of Invoice ' . $row['InvoiceId'] . ' is blank.');
         }
         if (!EDI.TestFile && $EDIObj->ErrorOnBlankInvoiceDate) {
            throw new EdiException('The Invoice Date of Shipment ' . $row['ShpID'] . ' is blank.');
         }
      }
         
      $TempStr .= 'L' . $EDIObj->delimiters->ElementDelimiter; // B3 05
      if ($EDIObj->use4DigitYear) {
         $TempStr .= DateTimeFunctions::GetDateStr($row['B3_06Date'], true) . $EDIObj->delimiters->ElementDelimiter; // B3 06
      } else {
         $TempStr .= DateTimeFunctions::GetDateStr($row['B3_06Date'], false) . $EDIObj->delimiters->ElementDelimiter; // B3 06
      }
            
      $TempStr .= CurrencyFunctions::ConvertMoneyToCents($row['InvoiceAmount']) . $EDIObj->delimiters->ElementDelimiter; // B3 07
            
      if (array_key_exists('B3_08CorrectionIndicator', $row)) {
         $B3_08CorrectionIndicator = $row['B3_08CorrectionIndicator'];
      } else {
         $B3_08CorrectionIndicator = '';
      }
               
      if ($EDIObj->use4DigitYear) {
         $TempStr .= $B3_08CorrectionIndicator . $EDIObj->delimiters->ElementDelimiter; //BG 08
         $TempStr .= DateTimeFunctions::GetDateStr($row['ArriveTimeDestination'], true) . $EDIObj->delimiters->ElementDelimiter; //BG 09
      } else {
        $TempStr .= $B3_08CorrectionIndicator . $EDIObj->delimiters->ElementDelimiter;
        $TempStr .= DateTimeFunctions::GetDateStr($row['ArriveTimeDestination'], false) . $EDIObj->delimiters->ElementDelimiter; //BG 08 09
      }
                  
      if (array_key_exists('B310Qualifier', $row)) {
         $TempStr .= $row['B310Qualifier'] . $EDIObj->delimiters->ElementDelimiter . $row['B3SCAC'];  // B3 10 11
      } else {
        $TempStr .= '010' . $EDIObj->delimiters->ElementDelimiter . $row['B3SCAC'];  // B3 10 11
      }
                     
      // These are not used, but required by the 4010 spec. They are also not specific so implementation
      // would be better delayed until we actually have a customer that uses them.
      if ($EDIObj->ediVersionReleaseCode == '4010') {
         if (array_key_exists('B3_12Date', $row)) {
            if ($EDIObj->use4DigitYear) {
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . DateTimeFunctions::GetDateStr($row['B3_12Date'], true) . $EDIObj->delimiters->ElementDelimiter;
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; //B3 12, 13, 14
            } else {
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . DateTimeFunctions::GetDateStr($row['B3_12Date'], false) . $EDIObj->delimiters->ElementDelimiter;
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; //B3 12, 13, 14
            }
         } else {
           $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; // B3 12, 13, 14
         }
      }
      return $TempStr;
   }
   
      
   public static function GetC3Line(EDISendOptions $EDIObj, $row) : string
   {
      //TODO 1 -oBrad Gies -cWhen bored : should be pulling the currency code from the query, so that it can be specific to this shipment }
      if ($EDIObj->ediVersionReleaseCode == '4010') {
         $TempStr = 'C3' . $EDIObj->delimiters->ElementDelimiter . 'USD' . 
            $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . 
            'USD' . $EDIObj->delimiters->ElementDelimiter;
      } else {
         $TempStrt = 'C3' .  $EDIObj->delimiters->ElementDelimiter . 'USD' . 
            $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . 
            $EDIObj->delimiters->ElementDelimiter;
      }
      return $TempStr;
   }
      
   
   //======================================================================
   public static function GetG62Segment(Send210Options $EDIObj, $row) : string
   {
      if ((array_key_exists('G62DateQualifier', $row)) && (array_key_exists('G62Date', $row))) {
         if (strlen((string) $row['G62DateQualifier']) != 2) {
            throw new EdiException('The G62DateQualifier field must be 2 characters');
         }
         $retVal = 'G62' . $EDIObj->delimiters->ElementDelimiter . $row['G62DateQualifier'] . $EDIObj->delimiters->ElementDelimiter . DateTimeFunctions::GetDateStr($row['G62Date'], $EDIObj->use4DigitYear);  // G62 01 02
      } else {
         $retVal = 'G62' . $EDIObj->delimiters->ElementDelimiter . '11' . $EDIObj->delimiters->ElementDelimiter . DateTimeFunctions::GetDateStr($row['ShippedOnDate'], $EDIObj->use4DigitYear);  // G62 01 02
      }
      return $retVal;
      // TODO 1 -oBrad Gies -cWhen bored : Version 4010 has more elements than we are showing here. Need to implement them, but no customers are using them at this time. }
   }
      
   
   public static function GetL0Segment(array $DataSet, int $LXLoopCount, Send210Options $EDIObj) : string
   {
      if ($EDIObj->Loop0400Options->SkipL0SegmentWhenFieldsBlank 
         && ( ($DataSet['Weight'] == '') || ($DataSet['Weight'] == Null) )
         && ( ($DataSet['Pieces'] = '') || ($DataSet['Pieces'] == Null))) {
         return '';
      }
   
      if ($DataSet['L003Qualifier'] == null) {
         $L003Qualifier = 'LB';
      } else {
         $L003Qualifier = substr($DataSet['L003Qualifier'], 0, 2);
      }   
      
      $weight = str_replace(',', '', (string) $DataSet['Weight']);
         
      $Result = 'L0' . $EDIObj->delimiters->ElementDelimiter . $LXLoopCount . $EDIObj->delimiters->ElementDelimiter; // L0 01
      if ($DataSet['Weight'] != '') {
         $Result .= $weight . $EDIObj->delimiters->ElementDelimiter . $L003Qualifier . $EDIObj->delimiters->ElementDelimiter; // L0 02-03
      } else {
          $Result .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; // L0 02-03
      }
            
      if ($DataSet['Weight'] <> '') {
         
         $Result .= $weight . $EDIObj->delimiters->ElementDelimiter . 'G' . $EDIObj->delimiters->ElementDelimiter;  // L0 04-05
      } else {
         $Result .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;  // L0 04-05
      }
               
      $Result .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;    // L0 06 07
        
/*      
      if ($DataSet['Pieces'] != '') {
         $Result .= $DataSet['Pieces'] . $EDIObj->delimiters->ElementDelimiter . 'PCS'
            . $EDIObj->delimiters->ElementDelimiter// L0 08-09-10-11
            . $EDIObj->delimiters->ElementDelimiter . 'L';
      } else {
         $Result .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter
                        . $EDIObj->delimiters->ElementDelimiter ;// L0 08-09-10-11
      }
*/      
      return $Result;
   }
                        
   
   public static function GetL3Segment(array $row, float $TotalCharges, Send210Options $EDIObj) : string
   {
      $Result = 'L3' . $EDIObj->delimiters->ElementDelimiter;
      if ($EDIObj->ediVersionReleaseCode == 4010) {
         $Result .= CurrencyFunctions::RemoveDecimals($row['Weight']) . $EDIObj->delimiters->ElementDelimiter;  // L301
      } else {
         $Result .= CurrencyFunctions::RemoveDecimals($row['Weight']) . $EDIObj->delimiters->ElementDelimiter;  // L301
      }
      

      if (array_key_exists('WeightQualifier', $row)) {
         $Result .= $row['WeightQualifier'] . $EDIObj->delimiters->ElementDelimiter;
      } else {
         $Result .= 'G' . $EDIObj->delimiters->ElementDelimiter;            // L302 changed to G 01/15/03 for Version 4010.
      }
         
      $Result .= $EDIObj->delimiters->ElementDelimiter ;  // L303
         
      // the 3020 and 4010 use L3 04, the other versions don't.
      //  if ((EDI.VersionReleaseCodeInt = ve3020) or (EDI.VersionReleaseCodeInt = ve4010)) then
      // code above commented because currently all version that we are sending
      // use the L3 04
      $Result .= $EDIObj->delimiters->ElementDelimiter; // L3 04
         
      // compare total charges here
      // first the test file and negative amounts
      if ($EDIObj->isTestFile && $EDIObj->TestFile->ErrorOnNegativeInvoiceAmount) {
         if (($row['InvoiceAmount'] < 0.0) && (abs($row['InvoiceAmount']) > 0.004)) {
            array_push($EDIObj->ErrorList, 'The Invoice Amount for shipment # ' . $row['ShpID'] . ' is negative.');
         }
      }
      // then test file and zero amounts
      if ($EDIObj->isTestFile && ($EDIObj->TestFile->ErrorOnZeroInvoiceAmount)) {
         if (abs($row['InvoiceAmount']) < 0.004) {
            array_push($EDIObj->ErrorList, 'The Invoice Amount for shipment # ' . $row['ShpID'] . ' is zero.');
         }
      }
         
      // then production files and negative amounts
      if ((! $EDIObj->isTestFile) && $EDIObj->TestFile->ErrorOnNegativeInvoiceAmount) {
         if (($row['InvoiceAmount'] < 0.0) && (abs($row['InvoiceAmount']) > 0.004)) {
            throw new \App\Exceptions\EdiFatalException('The InvoiceAmount for shipment # ' . $row['ShpID'] . ' is negative.');
         }
      }

      // then production files and zero amounts.
      if ((! $EDIObj->isTestFile) && $EDIObj->TestFile->ErrorOnZeroInvoiceAmount) {
         if (abs($row['InvoiceAmount']) < 0.004) {
            throw new \App\Exceptions\EdiFatalException('The Invoice Amount for shipment # ' . FieldByName('ShpID').AsString . ' is zero.');
         }
      }
             
      $fmt = numfmt_create( 'en_US', \NumberFormatter::CURRENCY );
      $fmt->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'US');
      $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
      
      
      //number_format( $detailRow['ItemTotal'], 2, '.', ',' );
      // then Non Matching amounts.
      if (abs($TotalCharges) > 0.004) {
         if (abs( $TotalCharges - $row['InvoiceAmount']) > 0.004) {
            if ($EDIObj->isTestFile) {
               array_push($EDIObj->ErrorList, 'The InvoiceAmount (' .  $fmt->format($row['InvoiceAmount']) .  ') for Invoice # ' . $row['InvoiceId'] . ' does not match the total line items (' . $fmt->format($TotalCharges) . ').');
            } else {
               throw new \App\Exceptions\EdiFatalException('The Invoice Amount (' .  $fmt->format($row['InvoiceAmount']) .  ') for shipment # ' . $row['InvoiceId'] . ' does not match the total line items (' . $fmt->format($TotalCharges) . ').');
            }
         }
      }
            
      return $Result . CurrencyFunctions::ConvertMoneyToCents($row['InvoiceAmount']) ;  // L305
   }
            
   
   
   
   //====================================================
   public static function GetN7Segment(Send210Options $EDIObj, $row) : string
   {
      $TempStr = 'N7' .  $EDIObj->delimiters->ElementDelimiter;
      $TempStr .= $EDIObj->delimiters->ElementDelimiter; // N7 01 not used by anyone right now.
   
      //{ TODO 1 -oBrad Gies -cWhen bored : Need to add a Default Unit Number Property that can be set or left blank. }
   
      if (!array_key_exists('UnitNumber', $row) ||  strlen(trim($row['UnitNumber'])) < 1) {
         $TempStr .= 'N/A';  // N702
      } else {
         $TempStr .= trim(substr($row['UnitNumber'], 0, 10));  // N702
      }
      
      $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter .
         $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . 
         $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . 
         $EDIObj->delimiters->ElementDelimiter;  // N7 03-10
      
      // NOTE TL means trailer (not otherwise specified) . We need to do work on this
      // to be able to send the proper Equipment codes. TL is the most generic that will
      // be correct most of the time.
      $TempStr .= 'TL'; // N7 11
      
      //  if FindField('VtpLength') <> nil then
      //    begin
      $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . 
               $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; // N7 12-14
      
      // the Length is left zero padded to 3 characters (feet) and inches are two characters 00.
      // send 1 if the length is zero.
      if (array_key_exists('Length', $row) && (int) $row['Length'] >= 1) {
         $TempStr .= str_pad( (int) $row['Length'] / 12, 10, ' ', STR_PAD_LEFT) . str_pad($row['vtpLength'] % 12, 2, '0');
      } else {
         //$TempStr .= str_pad( (int) (1 / 12), 3, '0'. STR_PAD_LEFT) . str_pad( (int) (1 % 12), 2, '0'. STR_PAD_LEFT);
      }
         
      if (array_key_exists('EquipmentDescriptionCode', $row)) {
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter .
               $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter .  // N7 15-21
               $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;    //
         
         $TempStr .= Row['EquipmentDescriptionCode'];
      }
      return $TempStr;
   }
         
   
   
   
}

<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentB3
{
   public $versions = array (
      '4010'
   );

   public static function isVersionTested(string $inVersion) : bool
   {
      if (in_array($inVersion, $versions)) {
         return true;
      }
      return false;
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
         if ($EDIObj->isTestFile && $EDIObj->testFileOptions->ErrorOnBlankInvoiceDate) {
            throw new EdiException('The Invoice Date of Invoice ' . $row['InvoiceId'] . ' is blank.');
         }
         if (!EDI.isTestFile && $EDIObj->testFileOptions->ErrorOnBlankInvoiceDate) {
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
   
   

   // this was programmed for the 4010 version
   public static function B3SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      $dataset['B3-01-ShipmentQualifier'] = $segmentArray[1];
      $dataset['B3-02-InvoiceNumber'] = $segmentArray[2];
      $dataset['B3-03-ShipmentIdentificationNumber'] = $segmentArray[3];
      $dataset['B3-04-ShipmentMethodOfPayment'] = $segmentArray[4];
      $dataset['B3-05-WeightUnitCode'] = $segmentArray[5];
      $dataset['B3-06-Date'] = $segmentArray[6];
      $dataset['B3-07-NetAmountDue'] = $segmentArray[7];
      $dataset['B3-08-CorrectionIndicator'] = $segmentArray[8];
      $dataset['B3-09-DeliverDate'] = $segmentArray[9];
      $dataset['B3-10-DateTimeQualifier'] = $segmentArray[10];
      $dataset['B3-11-StandardCarrierAlphaCode'] = $segmentArray[11];
      $dataset['B3-12-Date'] = $segmentArray[12];
      $dataset['B3-13-TariffServiceCode'] = $segmentArray[13];
      $dataset['B3-14-TransportationTermsCode'] = $segmentArray[14];
      
      return $dataset;
   }
}
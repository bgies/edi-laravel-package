<?php

namespace Bgies\EdiLaravel\Functions;


//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\Delimiters;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;


class ReadFileFunctions //extends BaseController
{
   
   public static function ReadAK1Line(string $Str, Delimiters $delimiters, &$dataSet )
   {
      $Result = true;
      $FullStr = $Str;
      
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK1
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK1 01
      $TempLength = strlen($TempStr);
      if (($TempLength < 1) or ($TempLength > 2)) {
         throw new EdiException('The Length of the Functional Identifier Code in the AK1 line must be 1 or 2 characters.');
      }
      
      $dataSet['FunctionalIdentifierCode'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK1 02
      $TempLength = strlen($TempStr);
      if (($TempLength < 1) || ($TempLength > 9)) {
         throw new EdiFatalException('The Length of the "Data Interchange Control Number" in the AK1 line must be 1-9 characters.');
      }
      $dataSet['DataInterchangeControlNumber'] = $TempStr;
   }

   
   public static function ReadAK2Line(string $Str, Delimiters $delimiters, &$dataSet)
   {
      $FullStr = $Str;
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK2
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK2 01
      $dataSet['TransactionSetIdentifierCode'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK2 02
      $dataSet['TransactionSetControlNumber'] = $TempStr;
   }

   
   public static function ReadAK3Line(string $Str, Delimiters $delimiters, &$masterDataSet)
   {
      $FullStr = $Str;
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK3
      
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK3 01  Segment ID code
      $masterDataSet['AK301'] = $TempStr;
      $masterDataSet['DetailDataSet']['SegmentIDCode'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK3 02  Segment Position
      $dataSet['SegmentPosition'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK3 03  Loop Identifier code
      $dataSet['LoopIdentifierCode'] = trim($TempStr);
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK3 04 segment Note code
      $dataSet['SegmentSyntaxErrorCode'] = trim($TempStr);
   
      // enter the Complete AK3 line as the error Description field so we can write it
      // to the database if needed.
      $dataSet['ErrorDescription'] = trim($FullStr);
   }

   
   // NOTE - AK4 is not implemented due to lack of test files with it included
   public static function ReadAK4Line(string $Str, Delimiters $delimiters, &$dataSet)
   {
      $FullStr = $Str;

      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK4
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK4 01
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK4 02
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK4 03
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK4 04
   }

   
   public static function ReadAK5Line(string $Str, Delimiters $delimiters, &$dataSet)
   {
      $FullStr = $Str;
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK5
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 01
   
      $dataSet['SetAcknowledgmentCodeSegment'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 02
      $dataSet['TransactionSetNoteCode1'] = $TempStr;
   
      if (strlen($Str) > 0) {
         $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 03
         $dataSet['TransactionSetNoteCode2'] = $TempStr;
   
         $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 04
         $dataSet['TransactionSetNoteCode3'] = $TempStr;
   
         $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 04
         $dataSet['TransactionSetNoteCode4'] = $TempStr;
   
         $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK5 06
         $dataSet['TransactionSetNoteCode5'] = $TempStr;
      }
   }

   
   public static function ReadAK9Line(string $Str, Delimiters $delimiters, &$dataSet)
   {
      $FullStr = $Str;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // Get rid of AK9
   
     $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK9 01
     $TempLength = strlen($TempStr);
     If ($TempLength != 1) {
        throw new EdiFatalException('The Length of the "Group Acknowledge Code" in the AK9 line must be 1 character.');
     }   
      $dataSet['GroupAcknowledgeCode'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK9 02
      $dataSet['NumberOfTransactionSetsIncluded'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK9 03
      $dataSet['NumberOfReceivedTransactionSets'] = $TempStr;
   
      $TempStr = SegmentFunctions::BreakLine($Str, $delimiters);  // AK9 03
      $dataSet['NumberOfAcceptedTransactionSets'] = $TempStr;
   }
   
   
   
   

}

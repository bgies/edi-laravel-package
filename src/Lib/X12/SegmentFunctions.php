<?php

namespace Bgies\EdiLaravel\Lib\X12;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\Delimiters;
use Bgies\EdiLaravel\Lib\X12\Options\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\read\EDIReadOptions;
use App\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\FileFunctions;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Carbon\Carbon;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use App\Exceptions\EdiFatalException;
use Bgies\EdiLaravel\Lib\X12\Options\Read\Read997Options;



//require_once "../../lib/SharedTypes.php";
//use Bgies\EdiLaravel\lib\x12\objects\Delimiters;


class SegmentFunctions 
{
   
   public static function getSegmentType(string $inStr, $Delimiters, SharedTypes $sharedTypes) : string 
   {
      $TempStr = (string) trim(SegmentFunctions::BreakLine($inStr, $Delimiters));  // pick the Segment Name
      
      if (!in_array($TempStr, $sharedTypes->SegmentTypes, false)) {
         throw new EdiFatalException('Unknown Segment Type: ' . $TempStr);
      }
      
      return $TempStr;
   }

   public static function BreakLine(string &$Str, $Delimiters) : string
   {
      if ($Str == '') {
         return '';
      }

      if (($Delimiters->ComponentElementSeparator != ' ')
         && ($Delimiters->ComponentElementSeparator != '')
         && (strpos($Delimiters->ComponentElementSeparator, $Str) > 0)) {
            $Str = substr($Str, 0, strpos($Delimiters->ComponentElementSeparator, $Str) - 1);
      }
      $AtCharPos = strpos($Str, $Delimiters->ElementDelimiter);

      if (!$AtCharPos) {
         $retVal = $Str;
         $Str = '';
         return $retVal;
      }

      if ($AtCharPos == 0) {
         $Str = substr($Str, 1);
         return '';
      }
      
      $Result = substr($Str, 0, $AtCharPos);
      $Str = substr($Str, $AtCharPos + 1);
      return $Result;
   }
      
   
   
   //public static function GetISASegment(EDISendOptions $EDIObj) : string
   public static function GetISASegment($EDIObj) : string
   {
      \Log::info('Bgies\EdiLaravel\Lib\X12\SegmentFunctions  GetISASegment');
      $TempStr = '';
      // write the header
      $TempStr .= 'ISA' .  $EDIObj->delimiters->ElementDelimiter . '00' . $EDIObj->delimiters->ElementDelimiter; // ISA01 101
      $TempStr .= '          ' . $EDIObj->delimiters->ElementDelimiter;   //ISA02 102
      $TempStr .= '00' . $EDIObj->delimiters->ElementDelimiter;          //ISA03 103
      $TempStr .= str_pad('', 10, ' ', STR_PAD_LEFT) . $EDIObj->delimiters->ElementDelimiter; // ISA04 104
      
      if ($EDIObj->interchangeSenderQualifier == '') {
         $TempStr .= 'ZZ' . $EDIObj->delimiters->ElementDelimiter; //ISA05 105
      }
      else {
         $TempStr .= $EDIObj->interchangeSenderQualifier . $EDIObj->delimiters->ElementDelimiter; //ISA05 105
      }
    
      if (empty($EDIObj->interchangeSenderID)) {
         throw new EdiException('The InterchangeSenderID property is blank', 0, null);
         //throw new EdiException('The InterchangeSenderID property is blank', 0, 10, 'SegmentFunctions', 31);
         //Raise EEDIMissingInformation.Create('The InterchangeSenderID property is blank');
      }
      
      if ( $EDIObj->fileDirection == 'outgoing' ) {
         $TempStr .= str_pad($EDIObj->interchangeSenderID, 15, ' ', STR_PAD_RIGHT) . $EDIObj->delimiters->ElementDelimiter; // ISA 06
         
         if (empty($EDIObj->interchangeReceiverQualifier)) {
            $TempStr .= 'ZZ' . $EDIObj->delimiters->ElementDelimiter; // ISA 07
         } else {
            $TempStr .= $EDIObj->interchangeReceiverQualifier . $EDIObj->delimiters->ElementDelimiter; // ISA 07
         }
      }
      else {
         // These are replies so the Sender and Receiver ID's are reversed.
         $TempStr .= str_pad($EDIObj->interchangeReceiverID, 15, ' ', STR_PAD_RIGHT) . $EDIObj->delimiters->ElementDelimiter; // ISA06 106
         if (empty($EDIObj->interchangeReceiverQualifier)) {
            $TempStr .= 'ZZ' . $EDIObj->delimiters->ElementDelimiter; // ISA 07
         } else {
            $TempStr .= $EDIObj->interchangeReceiverQualifier . $EDIObj->delimiters->ElementDelimiter; // ISA 07
         }
      }
      
      $TempStr .= str_pad($EDIObj->interchangeReceiverID, 15, ' ', STR_PAD_RIGHT) . $EDIObj->delimiters->ElementDelimiter; // ISA08
      
     // Date is in year, month, day format (2 digit years)
//     $TempStr .= $EDIObj->edi2DigitYearDate . $EDIObj->delimiters->ElementDelimiter ; // ISA09 108
        
     if ($EDIObj->use4DigitYear && $EDIObj->ediVersionReleaseCode != '4010') {
        if ($EDIObj->edi4DigitDate == '') {
           throw new EdiException('The EDI4DigitDateProperty is blank', 0, null);
        }
        $TempStr .= $EDIObj->edi4DigitDate . $EDIObj->delimiters->ElementDelimiter;  // ISA09 108
     } else {
        if ($EDIObj->edi2DigitYearDate == '') {
           throw new EdiException('The EDI2DigitYearDate Property is blank', 0, null);
        }
        $TempStr .= $EDIObj->edi2DigitYearDate . $EDIObj->delimiters->ElementDelimiter ; // ISA09 108
     }
     if ($EDIObj->ediTime == '') {
        throw new EdiException('The EDITime Property is blank', 0, null);
     }
     $TempStr .= $EDIObj->ediTime . $EDIObj->delimiters->ElementDelimiter; // ISA10 109
         
     switch ($EDIObj->ediVersionReleaseCode) {
        case '4010' : $TempStr .= 'U' . $EDIObj->delimiters->ElementDelimiter; // ISA11 110
             break;
        case '5010' : $TempStr .= '^' . EDIObj.Delimiters.Delimiter; // ISA11 I10
             break;
        default     : throw new EdiException('Unknown EDIObj->ediVersionReleaseCode', 0, null);
     }
         
     if ($EDIObj->interchangeControlVersionNumber == '') {
        array_push($EDIObj->errorList, 'The InterchangeControlVersionNumber property is blank');
        throw new EdiException('The InterchangeControlVersionNumber property is blank', 0, null);
     }
      
     $TempStr .= $EDIObj->interchangeControlVersionNumber . $EDIObj->delimiters->ElementDelimiter; // ISA12
     //$TempStr .= str_pad($EDIObj->interchangeControlVersionNumber, 15, '0', STR_PAD_LEFT) . $EDIObj->delimiters->ElementDelimiter; // ISA12
     if ($EDIObj->interchangeControlVersionNumber == '00401') {
         $TempStr .= str_pad($EDIObj->dataInterchangeControlNumber, 9, '0', STR_PAD_LEFT) . $EDIObj->delimiters->ElementDelimiter; // ISA13 112
     } else {
        $TempStr .= str_pad($EDIObj->dataInterchangeControlNumber, 15, '0', STR_PAD_LEFT) . $EDIObj->delimiters->ElementDelimiter; // ISA13 112
     }
     
     $TempStr .= '1' . $EDIObj->delimiters->ElementDelimiter; // ends at acknowledgement Requested.
     if ($EDIObj->isTestFile) {
        $TempStr .= 'T' . $EDIObj->delimiters->ElementDelimiter; // T is for test, change to P for production.
     } else {
       $TempStr .= 'P' . $EDIObj->delimiters->ElementDelimiter;   // ISA 15
     }
     $TempStr .= '<';
     \Log::info('Bgies\EdiLaravel\Lib\X12\SegmentFunctions: ' . $TempStr . '  Length: ' . strlen($TempStr));
     
     return $TempStr;
   }
   
   //public static function GetIEASegment(int $LineCount, EDISendOptions $EDIObj) : string
   public static function GetIEASegment(int $LineCount, $EDIObj) : string
   {
      return 'IEA' . $EDIObj->delimiters->ElementDelimiter . $LineCount . $EDIObj->delimiters->ElementDelimiter . str_pad($EDIObj->dataInterchangeControlNumber, 9, '0', STR_PAD_LEFT);
   }  
   
      
   //public static function GetGSSegment(EDISendOptions $EDIObj)
   public static function GetGSSegment($EDIObj)
   {
      \Log::info('Bgies\EdiLaravel\Lib\X12\SegmentFunctions::GetGSSegment  $EDIObj: ' . print_r($EDIObj, true));
      $Continue = true;
      
      $TempStr = 'GS' . $EDIObj->delimiters->ElementDelimiter;
      
      if (empty($EDIObj->transactionSetIdentifier)) {
         throw new EdiException('The GS Line cannot be sent unless the EDI file type is set. Aborting...', 0, null);
         $Continue = false;
      }
      
      if ($EDIObj->fileDirection == 'outgoing') {
         $Continue = true;
      
         switch($EDIObj->transactionSetIdentifier) {
            case '204' : $TempStr .= 'SM' . $EDIObj->delimiters->ElementDelimiter; break; // GS01 479
            case '210' : {
               $TempStr .= 'IM' . $EDIObj->delimiters->ElementDelimiter; // GS01 479
               $Continue = true;
               break;
            }
            case '214' : {
               $TempStr .= 'QM' . $EDIObj->delimiters->ElementDelimiter; // GS01 479
               $Continue = true;
               break;
            }
            case '270' : $TempStr .= 'HS' . $EDIObj->delimiters->ElementDelimiter; break;  // GS01 479
            case '271' : $TempStr .= 'HB' + $EDIObj->delimiters->ElementDelimiter; break;  // GS01 479
            case '835' : $TempStr .= 'HP' + $EDIObj->delimiters->ElementDelimiter; break;  // GS01 479
            case '837' : $TempStr .= 'HC' + $EDIObj->delimiters->ElementDelimiter; break;  // GS01 479
            case '858' : {
               $TempStr .= 'SI' + $EDIObj->delimiters->ElementDelimiter;  // GS01 479
               $Continue = true;
               break;
            }
            case '997' : $TempStr .= 'FA' + $EDIObj->delimiters->ElementDelimiter; break; // GS01 479
            //    ft999 : TempStr := TempStr + '' + $EDIObj->delimiters->elementDelimiter;  // GS01 479
            default : $Continue = false; 
               break;
         }
         
         // most customer's use the same code for Interchange sender and
         // application sender codes so we check for an application sender code
         // and use it if it's there. If it's not then use the Interchange sender.
         if (empty($EDIObj->applicationSenderCode)) {
            $TempStr .= $EDIObj->applicationSenderCode . $EDIObj->delimiters->ElementDelimiter;   // GS02 142
         } else {
            $TempStr .= $EDIObj->interchangeSenderID . $EDIObj->delimiters->ElementDelimiter;   // GS02 142
         }
            
            // most customer's use the same code for Interchange receiver and
            // application Receiver codes so we check for an application receiver code
            // and use it if it's there. If it's not then use the Interchange receiver.
         if (empty($EDIObj->applicationReceiverCode)) {
            $TempStr .= $EDIObj->applicationReceiverCode + $EDIObj->delimiters->ElementDelimiter;   // GS03 142
         } else {
            $TempStr .= $EDIObj->interchangeReceiverID . $EDIObj->delimiters->ElementDelimiter;   // GS03 142
         }
      } else {
         // These are replies so the Sender and Receiver ID's are reversed.
         if ($EDIObj->transactionSetIdentifier == '824') {
            $TempStr .= 'AG' . $EDIObj->delimiters->ElementDelimiter;  // GS01 479
            $Continue = true;
         }
         if ($EDIObj->transactionSetIdentifier == '997') {
            $TempStr .= 'FA' . $EDIObj->delimiters->ElementDelimiter;  // GS01 479
            $Continue .= true;
         }
         if ($EDIObj->transactionSetIdentifier == '999') {
            $TempStr .= 'FA' . $EDIObj->delimiters->ElementDelimiter;  // GS01 479
            $Continue .= true;
         }
               
         $TempStr .= $EDIObj->interchangeReceiverID . $EDIObj->delimiters->ElementDelimiter; // GS02
         $TempStr .= $EDIObj->interchangeSenderID . $EDIObj->delimiters->ElementDelimiter;   // GS03
      }
               
      if (!$Continue) {
         throw new EdiException('The EDI file type (transactionSetIdentifier) is an unknown type. The GS Line needs the file type to be set. Aborting...', 0, null);
      }
               
      // HIPAA 5010 version uses 4 digit date
      if ($EDIObj->use4DigitYear) {
         $TempStr .= $EDIObj->edi4DigitYearDate . $EDIObj->delimiters->ElementDelimiter;  // GS04 373
      } else {
         $TempStr .= $EDIObj->edi2DigitYearDate . $EDIObj->delimiters->ElementDelimiter;  // GS04 373
      }
               
      $TempStr .= $EDIObj->ediTime . $EDIObj->delimiters->ElementDelimiter;           // GS 05 337
               
      $TempStr .= (string)$EDIObj->dataInterchangeControlNumber . $EDIObj->delimiters->ElementDelimiter; // GS 06 28
               
      if (empty($EDIObj->ediVersionReleaseCode)) {
         throw new EdiException('The GS Line needs the ediVersionReleaseCode property to be set. Aborting...', 0, null);
      }
      $TempStr .= $EDIObj->responsibleAgencyCode; // GS 07
               
      if (!empty($EDIObj->ediVersionReleaseCodeExtended)) {
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->ediVersionReleaseCodeExtended . '0';  // GS08
      } else {
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->ediVersionReleaseCode;  // GS08
      }
               
      return $TempStr;
         
   }
      
   public static function GetGESegment(int $ItemsCount, $EDIObj) : string
   {
      $TempStr = 'GE' . $EDIObj->delimiters->ElementDelimiter;
      $TempStr .= $ItemsCount . $EDIObj->delimiters->ElementDelimiter;
      $TempStr .= $EDIObj->dataInterchangeControlNumber;
      return $TempStr;
   }
   
   
   public static function GetGTSegment(int $ItemsCount, EDISendOptions $EDIObj)
   {
      $TempStr = 'GE' . $EDIObj->delimiters->ElementDelimiter;
      $TempStr .= TempStr . ItemsCount . $EDIObj->delimiters->ElementDelimiter;
      $TempStr .= TempStr . $EDIObj->delimiters->ElementDelimiter;
      return $TempStr;
   }
   
   
   public static function GetSESegment(int &$LineCount, Delimiters $delimiters, string $UniqueNumberStr) : string
   {
      $Result = 'SE' . $delimiters->ElementDelimiter;
      $Result .= ($LineCount + 1) . $delimiters->ElementDelimiter;
      $Result .= $UniqueNumberStr;
      return $Result;
   }
   
   /*
    * 
    * The primary function of Reading the ISA Segment is to set all the variables and 
    * delimiters, therefore it needs the EDI Options object 
   */ 
   public static function ReadISASegment(string $inStr, $lineCount, &$EDIObj, SharedTypes $sharedTypes) : bool
   {
      if (strlen($inStr) < 108) {
         throw new EdiException('Invalid ISA string passed to ReadISASegment, too short');  
      }
      if (strpos('ISA', $inStr) != 0) {
         throw new EdiException('Invalid EDI File, file does not begin with ISA');
      }
      if (strpos('ISA', $inStr) == 0) {
         $EDIObj->delimiters->ElementDelimiter = $inStr[3];
         
         $tempStr = substr($inStr, 0, 108);
         $isaArray = explode($EDIObj->delimiters->ElementDelimiter, $tempStr);
         
         $EDIObj->delimiters->SegmentTerminator = substr($isaArray[15], 0, 1);

         // set these here because they will be useful later if there are errors.
         $EDIObj->ediReplySettings->ISASegment = $inStr;
         $EDIObj->ediReplySettings->ISASegmentFilePos = $lineCount;
         
         $EDIObj->interchangeSenderQualifier = $isaArray[5];
         $EDIObj->interchangeSenderID = $isaArray[6];
         $EDIObj->interchangeReceiverQualifier = trim($isaArray[7]);
         $EDIObj->interchangeReceiverID = trim($isaArray[8]);
         
         $TempDate = SegmentFunctions::ReadDateStr($isaArray[9], 'ISA');
         $TempTime = SegmentFunctions::ReadTimeStr($isaArray[10], 'ISA');
         
         $TempDate->setTime($TempTime->hour, $TempTime->minute);
         $EDIObj->fileDateTime = $TempDate;
         
         $TempStr = $isaArray[12];
         $TempInt = (int) $isaArray[12];
         $ValidVersion = false;
         
         if (array_key_exists($TempStr, $sharedTypes->Versions)) {
            $ValidVersion = true;
         }
         
         if (($TempInt == 400) || ($TempInt == 401)) {
            $TempInt = 4010;
            $TempStr = '004010';
            $ValidVersion = true;
         }
         
         $EDIObj->interchangeControlVersionNumber = $TempStr;
         
         if (!$ValidVersion) {
            throw new EdiException('The Control Version Number is ' . $TempStr . '. This component set does not recognize that version yet');
         }

         if (strlen($isaArray[13]) <> 9) {
            throw new EdiException('Interchange Control Number is not 9 characters long');
         } else {
            $EDIObj->dataInterchangeControlNumber = (int) $isaArray[13];
         }
         
         //$TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters); // ISA 15
         if (strlen($isaArray[15]) <> 1) {
            throw new EdiException('The test indicator in the ISA line appears to be wrong. It is not a 1 character string');
         }
         if ($isaArray[15] != 'T' && $isaArray[15] != 'P') {
            throw new EdiException('The test indicator in the ISA line is not "T" or a "P". Aborting read');
         } else {
            if ($TempStr == 'P') {
               $EDIObj->isTestFile = false;
            } else {
               $EDIObj->isTestFile = true;
            }
         }
         
         switch ( (int) $EDIObj->interchangeControlVersionNumber) {
            case 200 : {
               $EDIObj->delimiters->ComponentElementSeparator = substr($isaArray[16], 0, 1);
               break;
            }
            default : {
               if (strlen($isaArray[16]) == 1) {
                  $EDIObj->delimiters->ComponentElementSeparator = $isaArray[16]; // ISA 16
               } else {
                  if ( (int) $EDIObj->interchangeControlVersionNumber == 204) {
                     $EDIObj->delimiters->ComponentElementSeparator = substr($isaArray[16], 0, 1);
                     $EDIObj->delimiters->SegmentTerminator = $isaArray[16][1];
                  } else {
                     $EDIObj->delimiters->ComponentElementSeparator = $isaArray[16][0];
                     $EDIObj->delimiters->SegmentTerminator = $isaArray[16][1];
                  }
               }
            }
            
            
         } // case
         
         return true;
         
         
      }
            
   }
   
   
   //======================================================================
   //public static function ReadISASegment(string $Str, EDIReadOptions &$EDIObj,
   /*
   public static function ReadISASegment(string $Str, &$EDIObj,
      bool $InProgram, int $LineCount, SharedTypes $sharedTypes) : bool
   {
      $retVal = true;
      $FullStr = $Str;
      if (strpos('ISA', $Str) != 0) {
         throw new EdiException('Invalid EDI File, file does not begin with ISA');         
      }
      if (strpos('ISA', $Str) == 0) {
         $EDIObj->delimiters->ElementDelimiter = $Str[3];
         $EDIObj->delimiters->SegmentTerminator = $Str[105];
         
         // set these here because they will be useful later if there are errors.
         $EDIObj->EDIReplySettings->ISASegment = $Str;
         $EDIObj->EDIReplySettings->ISASegmentFilePos = $LineCount;
   
         $EDIObj->delimiters->SegmentTerminator = ' ';
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // Get rid of ISA
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 01
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 02
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 03
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 04
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 05
         $EDIObj->interchangeSenderQualifier = trim($TempStr);
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 06
         $EDIObj->interchangeSenderID = trim($TempStr);

         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 07
         $EDIObj->interchangeReceiverQualifier = trim($TempStr);
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 08
         $EDIObj->interchangeReceiverID = trim($TempStr);
   
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 09
         $TempDate = SegmentFunctions::ReadDateStr($TempStr, 'ISA');
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 10
         $TempTime = SegmentFunctions::ReadTimeStr($TempStr, 'ISA');
         
         $TempDate->setTime($TempTime->hour, $TempTime->minute);
         
         $EDIObj->fileDateTime = $TempDate;
   
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 11
   
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 12
         $TempInt = (int) $TempStr;
         $ValidVersion = false;
       
         if (array_key_exists($TempStr, $sharedTypes->Versions)) {
            $ValidVersion = true;
         }

         if (($TempInt == 400) || ($TempInt == 401)) {
            $TempInt = 4010;
            $TempStr = '004010';
            $ValidVersion = true;
         }

         $EDIObj->interchangeControlVersionNumber = $TempStr;
            
         if (!$ValidVersion) {
            throw new EdiException('The Control Version Number is ' . $TempStr . '. This component set does not recognize that version yet');
         }
               
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 13
         if (strlen($TempStr) <> 9) {
               throw new EdiException('Interchange Control Number is not 9 characters long');
         } else {
            $EDIObj->dataInterchangeControlNumber = (int) $TempStr;
         }
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // ISA 14
         $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters); // ISA 15
         if (strlen($TempStr) <> 1) {
            throw new EdiException('The test indicator in the ISA line appears to be wrong. It is not a 1 character string');
         }
         if ($TempStr != 'T' && $TempStr != 'P') {
             throw new EdiException('The test indicator in the ISA line is not "T" or a "P". Aborting read');
         } else {
            if ($TempStr == 'P') {
               $EDIObj->isTestFile = false;
            } else {
               $EDIObj->isTestFile = true;
            }
         }
               
         switch ( (int) $EDIObj->interchangeControlVersionNumber) {
            case 200 : {
               $EDIObj->delimiters->ComponentElementSeparator = substr($Str, strlen($Str), 1);
               break;
            }
            default : {
               if (strlen($Str) == 1) {  
                  $EDIObj->delimiters->ComponentElementSeparator = $Str; // ISA 16
               } else {
                  if ( (int) $EDIObj->interchangeControlVersionNumber == 204) {
                     $EDIObj->delimiters->ComponentElementSeparator = substr($Str, 0, 1);
                     $EDIObj->delimiters->SegmentTerminator = $Str[1];
                  } else {
                     $EDIObj->delimiters->ComponentElementSeparator = $Str[0];
                     $EDIObj->delimiters->SegmentTerminator = $Str[1];
                  }
               }
            }

               
         } // case
         
         return true;
      }
   }
*/      
   //public static function ReadGSSegment(string $Str, EDIReadOptions &$EDIObj,
   public static function ReadGSSegment(string $Str, &$EDIObj,
      int $LineCount, SharedTypes $sharedTypes) : bool
   {
      $retVal = true;
      $FullStr = $Str;
      $SegmentArray = explode($EDIObj->delimiters->ElementDelimiter, $Str);
      if ($SegmentArray[0] !== 'GS') {
         throw new EdiException('The Segment passed to ReadGSSegment appears to be wrong. It does not start with GS');
      }
         
      // set these here because they will be useful later if there are errors.
      $EDIObj->ediReplySettings->GSSegment = $Str;
      $EDIObj->ediReplySettings->GSSegmentFilePos = $LineCount;

      $functionalIdentifierCode = $SegmentArray[1];
      
      $EDIObj->applicationSenderCode = trim($SegmentArray[2]); // GS 02
      $EDIObj->applicationReceiverCode = trim($SegmentArray[3]); // GS 03
      
      $TempDate = SegmentFunctions::ReadDateStr($SegmentArray[4], 'GS'); // GS 04
      $TempTime = SegmentFunctions::ReadTimeStr($SegmentArray[5], 'GS');  // GS 05
      $TempDate->setTime($TempTime->hour, $TempTime->minute);

      $diff_in_minutes = $EDIObj->fileDateTime->diffInMinutes($TempDate);
      if ($diff_in_minutes > 1) {
         throw new EdiException('The dates and times in the ISA line and the GS line do not match. Aborting...');
      }

      $EDIObj->GSControlNumber = (int) $SegmentArray[6];  // GS 06

      $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters);  // GS 07

      $EDIObj->ediVersionReleaseCode = (int) $SegmentArray[8]; // GS 08
     
      $ValidVersion = false;
      
      for ($i = 0; $i < count($sharedTypes->Versions); $i++) {
         if ($EDIObj->ediVersionReleaseCode == $sharedTypes->Versions[$i]) {
            $ValidVersion = true;
         }
      }
      if (! $ValidVersion) {
         throw new EdiException('The Control Version Number in the GS line is ' . $TempStr . '. This component set does not recognize that version yet');
      }
     
      return true;
   }

//   public static function ReadSTSegment(string $Str, EDIReadOptions &$EDIObj, &$SegmentType,
   public static function ReadSTSegment(string $Str, &$EDIObj, &$SegmentType,
      int $LineCount, SharedTypes $sharedTypes) : bool
   {
      $retVal = true;
      $FullStr = $Str;
      $SegmentArray = explode($EDIObj->delimiters->ElementDelimiter, $Str);
      
      // set these here because they will be useful later if there are errors.
      $EDIObj->ediReplySettings->STSegmentFilePos = $LineCount;
         
      If (strpos('ST', strtoupper($SegmentArray[0])) <> 0) {
         throw new EdiFatalException('The ST line is malformed or missing');
      }
   
      if (!in_array($SegmentArray[1], $sharedTypes->X12TransactionSets)) {   // ST01
         throw new EdiFatalException('The ST segmentline is malformed, or the Transaction Set is not supported yet');
      }
      $EDIObj->transactionSetIdentifier = $SegmentArray[1];
      
      if ((strlen($SegmentArray[2]) > 9) || (strlen($SegmentArray[2]) < 4)) {
         throw new EdiFatalException('The ST segment is malformed, The TransactionSetControlNumber is not valid');
      }
      $EDIObj->transactionSetControlNumber = $SegmentArray[2];
      
      /*
       * The Implemtation Convention Reference is optional, so we don't rely
       * on it, but we do use it and enforce it, if it's there. 
       * It tells which transaction set is contained in this group
       */
      if (count($SegmentArray) > 3) {
         $EDIObj->implementationConventionReference = $SegmentArray[3];
      }
      
      return $retVal;
   }
      
   
   public static function ReadSESegment(string $Str, EDIReadOptions &$EDIObj,
      int $LineCount)
   {
      $FullStr = $Str;
      $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters); // get rid of SE
   
      // set these here because they will be useful later if there are errors.
      $EDIObj->EDIReplySettings->SESegmentFilePos = $LineCount;
   
   
      if (strpos('SE', strtoupper($TempStr)) != 0) {
         throw new EdiFatalException('The SE line is malformed or missing');
      }
   
      $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters); // ST01
      $TempInt = (int) $TempStr;
      if ($TempInt != $LineCount) {
         throw new EdiFatalException('An SE line has the wrong line count. The EDI file may be malformed.');
      }
   
      $TempStr = SegmentFunctions::BreakLine($Str, $EDIObj->delimiters); // ST02
   }
   
   
    
   
  // File type is the EDI type ie 210, 214, 0r 997
  public static function getSTSegment($EDIFileType, \Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions $EDIObj, int $Counter, string &$UniqueNumberStr ) : string 
  {
     $TempStr = 'ST';
     
     $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIFileType; // ST 01
     
   
     if (empty($EDIObj->transactionSetControlNumber) && ($EDIObj->transactionSetControlNumber != 0)) {
        throw new \App\Exceptions\EdiException('The TransactionSetControlNumber is not valid. Aborting....');
     }
         
     $UniqueNumberStr = EdiFileFunctions::GetUniqueControlNumberStr($EDIObj, $Counter);
     
     $TempStr .= $EDIObj->delimiters->ElementDelimiter . $UniqueNumberStr; // ST 02
     
     if ($EDIObj->ediVersionReleaseCode == '4010') {
        return $TempStr;
     }
     
     
     $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->ediVersionReleaseCode; // ST 03
     
     $TempStr .= $EDIObj->delimiters->ElementDelimiter . $UniqueNumberStr; // ST 04
     $EDIObj->UniqueControlNumber = $UniqueNumberStr;
     
     if ($EDIObj->ediVersionReleaseCodeExtended <> '') {
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->ediVersionReleaseCodeExtended;  // ST 08
     } else
     $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->ediVersionReleaseCode;  // GS08
     
     return $TempStr;
  }
  
  
   public static function ReadDateStr($Str, $LineType) : Carbon
   {
      $Str = trim($Str);
      if ((strlen($Str) != 6) && (strlen($Str) != 8)) {
         throw new EdiException('Invalid Date in ' . $LineType . ' line. Dates must be either 6 or 8 characters. The malformed date is "' . $Str . '".');
      }
  
      if (strlen($Str) == 6) {
         $sYear = substr($Str, 0, 2);
         $sMonth = substr($Str, 2, 2);
         $sDay = substr($Str, 4, 2);
      } else {
         $sYear = substr($Str, 0, 4);
         $sMonth = substr($Str, 4, 2);
         $sDay = substr($Str, 6, 2);
      }
  
      $iYear = (int) $sYear;
      if ($iYear < 2000) {
         $iYear = $iYear + 1900;
      }
      if ($iYear < 1950) {
         $iYear = $iYear + 100;
      }
  
//      iMonth := StrToInt(sMonth);
//  iDay := StrToInt(sDay);
      $yearStr = (string) $iYear . '-' . $sMonth . '-' . $sDay;
      $carbonDate = Carbon::createFromFormat('Y-m-d', $yearStr);
      $carbonDate = $carbonDate->setTime(0, 0, 0, 0);
      
      return $carbonDate;
  }
   
  public static function ReadTimeStr($Str, string $LineType) : Carbon
  {
     if (strlen($Str) < 4) {
        throw new EdiException('Invalid Time in ' . $LineType . ' line. Time is not 4 characters.');
     }
  
     $sHour = substr($Str, 0, 2);
     $sMin = substr($Str, 2, 2);
  
     $timeStr = $sHour . ':' . $sMin;
     $carbonTime = Carbon::createFromFormat('H:i', $timeStr);
     $carbonTIme = $carbonTime->setDate(0, 0, 0);
     return $carbonTime;
  }

  
  
  
}
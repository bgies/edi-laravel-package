<?php

namespace Bgies\EdiLaravel\Lib\X12\Options;

use Bgies\EdiLaravel\Lib\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Lib\X12\ReplySettings;

abstract class BaseEdiOptions
{
   /**
    *
    * @var unknown
    */
   public $delimiters = null; // Delimiters object;
   public $interchangeControlVersionNumber = '00401';
   public $interchangeReceiverID = '';
   public $interchangeSenderID = '';
   public $interchangeSenderQualifier = 'ZZ';
   public $interchangeReceiverQualifier = 'ZZ';

   public $applicationSenderCode = '';
   public $applicationReceiverCode = '';
   public $transactionSetIdentifier = ''; // 210,850, INVOIC etc
   public $ediVersionReleaseCode = '4010';
   public $ediVersionReleaseCodeExtended = '00401';
   public $fileDirection = 'incoming'; // Must be null, incoming or outgoing.. NOTHING ELSE
   public $ediStandard = 'X12'; // from public $EDIStandard = array('Unknown', 'X12', 'EDIFACT', 'Custom');

   public $ediMemo = array(); // array of string
   public $errorCount = 0;
   public $errorList = array(); // array of string
   public $fileDateTime = null; // File Creation Date for outgoing files

   public $leftPadControlNumber = false;

   public $trimExtraDelimiters = false;
   public $writeOneLine = true;
   public $isTestFile = true;

   public $ediId = 0;
   public $dataInterchangeControlNumber = 0;
   public $ediReplySettings = null; // : TEDIReplySettings;
   public $useXDigitsFromControlNumber = 9;
   public $GSControlNumber = null;

   public bool $needs997 = false;
   public bool $needs999 = false;

   public $fileName = '';
   public $detailSQL = '';
   public bool $useDetailQuery = false;
   public bool $overwriteFile = false;

   public bool $use4DigitYear = false;
   public $edi2DigitYearDate = '';
   public $edi4DigitYearDate = '';
   public $ediTime = '';

   public $identificationCodeQualifier = 'ZZ';
   public $responsibleAgencyCode = ''; // str2;

   public $transactionSetControlNumber = 0;

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      \Log::info('classBaseEdiOptions __construct() ');
      $this->delimiters = new Delimiters();
      $this->edi2DigitYearDate = DateTimeFunctions::GetDateStr(now(), false);
      $this->edi4DigitYearDate = DateTimeFunctions::GetDateStr(now(), true);
      $this->ediTime = DateTimeFunctions::GetTimeStr(now(), 8);
      $this->ediMemo = array();
      $this->errorList = array();
      $this->ediReplySettings = new ReplySettings();

   }

   public function getPropertyTypes() {
      $propTypes = array();
      $propTypes['ComponentElementSeparator'] = new PropertyType(
         'string', 1, 1, false, true, null
         );
      $propTypes['ElementDelimiter'] = new PropertyType(
         'string', 1, 1, false, true, null
         );
      $propTypes['SegmentTerminator'] = new PropertyType(
         'string', 1, 1, false, true, null
         );
      $propTypes['ReleaseCharacter'] = new PropertyType(
         'string', 1, 1, false, true, null
         );
      $propTypes['DecimalPoint'] = new PropertyType(
         'string', 1, 1, false, true, null
         );
      return $propTypes;
   }


}


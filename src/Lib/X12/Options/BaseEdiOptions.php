<?php

namespace Bgies\EdiLaravel\Lib\X12\Options;

use Bgies\EdiLaravel\Lib\Delimiters;
use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Lib\X12\ReplySettings;
use Bgies\EdiLaravel\Lib\PropertyType;

abstract class BaseEdiOptions
{
   /**
    *
    * @var unknown
    */
   public $delimiters = null; // Delimiters object;
   public $testOptions = null;
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
   public int $errorCount = 0;
   public $errorList = array(); // array of string
   public $fileDateTime = null; // File Creation Date for outgoing files

   public bool $leftPadControlNumber = false;

   public bool $trimExtraDelimiters = false;
   public bool $writeOneLine = true;
   public bool $isTestFile = true;

   public int $ediId = 0;
   public $dataInterchangeControlNumber = 0;
   public $ediReplySettings = null; // : TEDIReplySettings;
   public int $useXDigitsFromControlNumber = 9;
   public ?int $GSControlNumber = null;

   public bool $needs997 = false;
   public bool $needs999 = false;

   public string $fileName = '';
   public string $detailSQL = '';
   public bool $useDetailQuery = false;
   public bool $overwriteFile = false;

   public bool $use4DigitYear = false;
   public string $edi2DigitYearDate = '';
   public $edi4DigitYearDate = '';
   public $ediTime = '';

//   public $identificationCodeQualifier = 'ZZ';
//   public $responsibleAgencyCode = ''; // str2;
//   public $transactionSetControlNumber = 0;

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //\Log::info('classBaseEdiOptions __construct() ');
      $this->delimiters = new Delimiters();
      //$this->testOptions = new 
      $this->edi2DigitYearDate = DateTimeFunctions::GetDateStr(now(), false);
      $this->edi4DigitYearDate = DateTimeFunctions::GetDateStr(now(), true);
      $this->ediTime = DateTimeFunctions::GetTimeStr(now(), 8);
      $this->ediMemo = array();
      $this->errorList = array();
      $this->ediReplySettings = new ReplySettings();

   }

   /*
    $this->propertyType = $propertyType;
    $this->minLength = $minLength;
    $this->maxLength = $maxLength;
    $this->allowNull = $allowNull;
    $this->required = $required;
    $this->dataElement = $dataElement;
    $this->canEdit = $canEdit;
    $this->displayInForm = $displayInForm;
    */ 
   
   public function getPropertyTypes() {
      $propTypes = array();
      $propTypes['delimiters'] = new PropertyType(
         'object', 0, 1, false, true, null, true, true
         );
      $propTypes['interchangeControlVersionNumber'] = new PropertyType(
         'string', 1, 15, false, true, null, true, true
         );
      $propTypes['interchangeReceiverID'] = new PropertyType(
         'string', 1, 15, false, true, null, true, true
         );
      $propTypes['interchangeSenderID'] = new PropertyType(
         'string', 1, 15, false, true, null, true, true
         );
      $propTypes['interchangeSenderQualifier'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['interchangeReceiverQualifier'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['applicationSenderCode'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['applicationReceiverCode'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['transactionSetIdentifier'] = new PropertyType(
         'string', 4, 8, false, true, null, true, true
         );
      $propTypes['ediVersionReleaseCode'] = new PropertyType(
         'string', 4, 8, false, true, null, true, true
         );
      $propTypes['ediVersionReleaseCodeExtended'] = new PropertyType(
         'string', 6, 8, false, true, null, true, true
         );
      $propTypes['fileDirection'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['ediStandard'] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
      $propTypes['ediMemo'] = new PropertyType(
         'array', 0, 20000, false, false, null, false, false
         );
      $propTypes['errorCount'] = new PropertyType(
         'int', 0, 20000, false, false, null, false, false
         );
      $propTypes['errorList'] = new PropertyType(
         'array', 0, 20000, false, false, null, false, false
         );
      $propTypes['fileDateTime'] = new PropertyType(
         'datetime', 0, 0, false, false, null, false, false
         );
      $propTypes['leftPadControlNumber'] = new PropertyType(
         'int', 0, 9, false, true, null, true, true
         );
      $propTypes['trimExtraDelimiters'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['writeOneLine'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['isTestFile'] = new PropertyType(
         'bool', 0, 1, false, false, null, false, false
         );
      $propTypes['ediId'] = new PropertyType(
         'int', 0, 20000000, false, false, null, false, false
         );
      $propTypes['dataInterchangeControlNumber'] = new PropertyType(
         'int', 0, 20000000, false, true, null, true, true
         );
      $propTypes['useXDigitsFromControlNumber'] = new PropertyType(
         'int', 1, 9, false, true, null, true, true
         );
      $propTypes['GSControlNumber'] = new PropertyType(
         'int', 0, 20000000, false, true, null, true, true
         );
      $propTypes['needs997'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['needs999'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['fileName'] = new PropertyType(
         'string', 0, 2000, false, false, null, false, false
         );
      $propTypes['detailSQL'] = new PropertyType(
         'textarea', 0, 20000, true, false, null, true, true
         );
      $propTypes['useDetailQuery'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );      
      $propTypes['overwriteFile'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['use4DigitYear'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['edi2DigitYearDate'] = new PropertyType(
         'string', 6, 6, true, false, null, false, false, ''
         );
      $propTypes['edi4DigitYearDate'] = new PropertyType(
         'string', 8, 8, true, false, null, false, false
         );
      $propTypes['ediTime'] = new PropertyType(
         'string', 0, 20, false, true, null, false, false
         );
      $propTypes['ediReplySettings'] = new PropertyType(
         'object', 0, 1, false, true, null, true, true
         );
      $propTypes['identificationCodeQualifier'] = new PropertyType(
         'string', 0, 0, false, true, null, false, false
         );
      $propTypes['responsibleAgencyCode'] = new PropertyType(
         'string', 0, 0, false, true, null, false, false
         );
      $propTypes['transactionSetControlNumber'] = new PropertyType(
         'int', 2, 2, false, true, null, false, false
         );
      
      
/*
  public function __construct(string $propertyType,
       int $minLength, int $maxLength, bool $allowNull,
       bool $required, ?int $dataElement, ?bool $canEdit = true,
       ?bool $displayInForm = true, ?string $propertyHelp = '')
    {
  
      $propTypes[''] = new PropertyType(
         'string', 2, 2, false, true, null, true, true
         );
*/      
      return $propTypes;
   }


}


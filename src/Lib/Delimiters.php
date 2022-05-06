<?php

namespace Bgies\EdiLaravel\Lib;


/**
 * 
 * @author rbgie_000
 *
 * Delimiters are used in both X12 and EDIFACT
 */
class Delimiters
{
   /**
    * All Delimiters are public and single char. All 5 are REQUIRED. Used in EDI file to "delimit" elements, segments etc
    */
   public $ComponentElementSeparator = ':';
   public $ElementDelimiter = '*';
   public $SegmentTerminator = '~';
   public $ReleaseCharacter = '?';  //Repetition separator (version 4020 and later)
   public $DecimalPoint = '.';

   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //parent::__construct();
       //$srcDir = dirname(__FILE__);
   }
   
   /**
    * @queryParam  DelimiterName Field to sort by
    * @queryParam  singleChar the character to use
    */
   
   public function setDelimiter($DelimiterName, $singleChar) {
      
      $this->$DelimiterName = $singleChar;
      
   }
   
}

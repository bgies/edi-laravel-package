<?php

namespace Bgies\EdiLaravel\Lib\X12;

use Bgies\EdiLaravel\Lib\PropertyType;

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
   public string $ComponentElementSeparator = ':';
   public string $ElementDelimiter = '*';
   public string $SegmentTerminator = '~';
   public string $ReleaseCharacter = '?';  //Repetition separator (version 4020 and later)
   public string $DecimalPoint = '.';

   
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
   
   public function getPropertyTypes() {
      $propTypes = array();
      $propTypes['ComponentElementSeparator'] = new PropertyType(
         'string', 1, 1, false, true, null, true, true
         );
      $propTypes['ElementDelimiter'] = new PropertyType(
         'string', 1, 1, false, true, null, true, true
         );
      $propTypes['SegmentTerminator'] = new PropertyType(
         'string', 1, 1, false, true, null, true, true
         );
      $propTypes['ReleaseCharacter'] = new PropertyType(
         'string', 1, 1, false, true, null, true, true
         );
      $propTypes['DecimalPoint'] = new PropertyType(
         'string', 1, 1, false, true, null, true, true
         );
      return $propTypes;
   }
   
   /**
    * @queryParam  DelimiterName Field to sort by
    * @queryParam  singleChar the character to use
    */
   
   public function setDelimiter($DelimiterName, $singleChar) {
      
      $this->$DelimiterName = $singleChar;
      
   }
   
}

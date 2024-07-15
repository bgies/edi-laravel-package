<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentL1 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
/*
 * NOTE - This segment does not include ALL elements because the spec I worked from
 *       did not include all the elements. 
 *       
 *       IF you add another EDI Type that includes this segment, you need to check to 
 *       make sure this segment read includes all the elements you need for the 
 *       new transaction set. 
*/      
      $dataset['L1-LadingLineItemNumber'] = $segmentArray[1];
      $dataset['L1-FreightRate'] = $segmentArray[2];
      $dataset['L1-RateValueQualifier'] = $segmentArray[3];
      $dataset['L1-Charge'] = $segmentArray[4];
      
      $dataset['L1-SpecialChargeAllowanceCode'] = $segmentArray[8];
      
      $dataset['L1-SpecialChargeDescription'] = $segmentArray[12];
      

      
   }
}
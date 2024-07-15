<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentL3 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      // NOTE - THIS CODE SNIPPET IS JUST BOILERPLATE TO GIVE YOU AN IDEA OF HOW TO PROGRAM IT
/*      
      if (! array_key_exists('L3Array', $dataset)) {
         $dataset['L3Array'] = [];
      }
      $dataset['L3Array'][] = [];
      $L3ArrayCount = count($dataset['L3Array']);
      
      $dataset['L3Array'][$L3ArrayCount - 1]['L3-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['L3Array'][$L3ArrayCount - 1]['L3-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      $dataset['L3-LadingLineItemNumber'] = $segmentArray[1];
      
      
   }
}
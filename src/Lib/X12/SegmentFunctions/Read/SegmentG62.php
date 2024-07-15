<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentG62 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      $dataset['G62-DateQualifier'] = $segmentArray[1];
      $dataset['G62-Date'] = $segmentArray[2];

/*      
      if (! array_key_exists('G62Array', $dataset)) {
         $dataset['G62Array'] = [];
      }
      $dataset['G62Array'][] = [];
      $G62ArrayCount = count($dataset['G62Array']);
      
      $dataset['G62Array'][$G62ArrayCount - 1]['G62-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['G62Array'][$G62ArrayCount - 1]['G62-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      
   }
}
<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentN3 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      // NOTE - THIS CODE SNIPPET IS JUST BOILERPLATE TO GIVE YOU AN IDEA OF HOW TO PROGRAM IT
/*      
      if (! array_key_exists('N3Array', $dataset)) {
         $dataset['N3Array'] = [];
      }
      $dataset['N3Array'][] = [];
      $N3ArrayCount = count($dataset['N3Array']);
      
      $dataset['N3Array'][$N3ArrayCount - 1]['N3-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['N3Array'][$N3ArrayCount - 1]['N3-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      $dataset['N3-EntityIdentifierCode'] = $segmentArray[1];
      
      
   }
}
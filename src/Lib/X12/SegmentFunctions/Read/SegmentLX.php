<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentLX extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      // NOTE - THIS CODE SNIPPET IS JUST BOILERPLATE TO GIVE YOU AN IDEA OF HOW TO PROGRAM IT
/*      
      if (! array_key_exists('LXArray', $dataset)) {
         $dataset['LXArray'] = [];
      }
      $dataset['LXArray'][] = [];
      $LXArrayCount = count($dataset['LXArray']);
      
      $dataset['LXArray'][$LXArrayCount - 1]['LX-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['LXArray'][$LXArrayCount - 1]['LX-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      $dataset['LX-Assigned Number'] = $segmentArray[1];
      
      
   }
}
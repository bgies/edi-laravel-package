<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentN7 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      // NOTE - THIS CODE SNIPPET IS JUST BOILERPLATE TO GIVE YOU AN IDEA OF HOW TO PROGRAM IT
/*      
      if (! array_key_exists('N7Array', $dataset)) {
         $dataset['N7Array'] = [];
      }
      $dataset['N7Array'][] = [];
      $N7ArrayCount = count($dataset['N7Array']);
      
      $dataset['N7Array'][$N7ArrayCount - 1]['N7-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['N7Array'][$N7ArrayCount - 1]['N7-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      $dataset['N7-02-EquipmentNumber'] = $segmentArray[2];
      $dataset['N7-011-EquipmentDescriptionCode'] = $segmentArray[11];
      
      
   }
}
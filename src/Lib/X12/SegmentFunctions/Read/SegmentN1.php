<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentN1 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {
      // NOTE - THIS CODE SNIPPET IS JUST BOILERPLATE TO GIVE YOU AN IDEA OF HOW TO PROGRAM IT

      $dataset['N1-EntityIdentifierCode'] = $segmentArray[1];
      $dataset['N1-Name'] = $segmentArray[2];
      $dataset['N1-IdentificationCodeQualifier'] = $segmentArray[3];
      $dataset['N1-IdentificationCode'] = $segmentArray[4];
/*      
      if (! array_key_exists('N1Array', $dataset)) {
         $dataset['N1Array'] = [];
      }
      $dataset['N1Array'][] = [];
      $N1ArrayCount = count($dataset['N1Array']);
      
      $dataset['N1Array'][$N1ArrayCount - 1]['N1-011-ReferenceIdentificationQualifier'] = $segmentArray[1];
      $dataset['N1Array'][$N1ArrayCount - 1]['N1-02-ReferenceIdentification'] = $segmentArray[2];
*/      
      
   }
}
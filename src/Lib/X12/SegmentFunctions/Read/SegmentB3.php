<?php

namespace Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions\BaseObjects\SegmentBase;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options;
use Bgies\EdiLaravel\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;



class SegmentB3 extends SegmentBase
{
   // this was programmed for the 4060 version
   public static function SegmentRead($segmentArray, &$EDIObj, &$dataset, $ediVersion) {

      $dataset['B3-01-ShipmentQualifier'] = $segmentArray[1];
      $dataset['B3-02-InvoiceNumber'] = $segmentArray[2];
      $dataset['B3-03-ShipmentIdentificationNumber'] = $segmentArray[3];
      $dataset['B3-04-ShipmentMethodOfPayment'] = $segmentArray[4];
      $dataset['B3-05-WeightUnitCode'] = $segmentArray[5];
      $dataset['B3-06-Date'] = $segmentArray[6];
      $dataset['B3-07-NetAmountDue'] = $segmentArray[7];
      $dataset['B3-08-CorrectionIndicator'] = $segmentArray[8];
      $dataset['B3-09-DeliverDate'] = $segmentArray[9];
      $dataset['B3-10-DateTimeQualifier'] = $segmentArray[10];
      $dataset['B3-11-StandardCarrierAlphaCode'] = $segmentArray[11];
      $dataset['B3-12-Date'] = $segmentArray[12];
      $dataset['B3-13-TariffServiceCode'] = $segmentArray[13];
      $dataset['B3-14-TransportationTermsCode'] = $segmentArray[14];
         
      return $dataset;
      
   }
}
<?php

namespace Bgies\EdiLaravel\Functions;

use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Lib\ReturnValues;



class ReadEdiFileFunctions
{
   public static function getEdiTypeFromEdiObject($EDIObj) : ReturnValues
   {
      $retValues = new ReturnValues();
      $retValues->ediType = null;
      
      if ($EDIObj->fileDirection == 'incoming') {
         $fileDirection = 1;
      } else {
         $fileDirection = 2;
      }
      \DB::connection()->enableQueryLog();
      $ediType = EdiType::query()
         ->where('edt_edi_standard', '=', $EDIObj->ediStandard)
         ->where('edt_is_incoming', '=', $fileDirection)
         ->where('application_sender_code', '=', $EDIObj->applicationSenderCode)
         ->where('interchange_receiver_id', '=', $EDIObj->interchangeReceiverID)
         ->where('interchange_sender_id', '=', $EDIObj->interchangeSenderID)
         ->where('application_receiver_code', '=', $EDIObj->applicationReceiverCode)
         ->where('edt_transaction_set_name', $EDIObj->transactionSetIdentifier)
         ->get();
      
      if (count($ediType) == 1) {
        $retValues->ediType = $ediType[0]; 
         
      }
      
      if (count($ediType) == 0) {
         $queries = \DB::getQueryLog();
         $populatedQuery = QueryFunctions::populateQuery($queries[0]['query'], $queries[0]['bindings']);
            
         $retValues->addToErrorList($populatedQuery);
         $retValues->addToErrorList('An EDI Type was not found for this file using the 4 sender/receiver ids plus edi standard and is_incoming');
         /*
          * We haven't found an EDI Type, so this could be a file we have created
          * and we just want to read it to test it.
          */
         $retValues->addToErrorList('If you are testing this file, you still need to create an  EDI Type and set it up properly');
         return $retValues;
      }
      
      if (count($ediType) >= 2) {
         $queries = \DB::getQueryLog();
         $populatedQuery = QueryFunctions::populateQuery($queries[0]['query'], $queries[0]['bindings']);
         
         $retValues->addToErrorList($populatedQuery);
         $retValues->addToErrorList('An EDI Type was not found for this file using the 4 sender/receiver ids plus edi standard and is_incoming');
         
      }
      
      return $retValues;
   }
   
   
   
   
   
   
}
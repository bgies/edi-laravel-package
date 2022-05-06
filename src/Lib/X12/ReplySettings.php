<?php

namespace Bgies\EdiLaravel\Lib\X12;


class ReplySettings
{
   public $AcknowledgeFileOn997 = true;
   public $AcknowledgeTransactionOn997Accepted = false;
   public $AcknlowledgeTransactionOn997Reject = true;
   public $AcknowledgeFileOn824 = true;
   public $AcknowledgeTransactionOn824Accepted = true;
   public $AcknlowledgeTransactionOn824Reject = true;
   public $ErrorSegment = '';
   public $ErrorTransaction = array();
   public $OnlyMatchControlNumberWithin = 0;
   public $SQLCommand824 = array();
   public $SQLCommand997 = array();

   public $DetailQuery = '';
   public $GESegment = '';
   public $GESegmentFilePos = -1;
   public $GSSegment = '';
   public $GSSegmentFilePos = -1;
   public $IEASegment = '';
   public $IEASegmentFilePos = -1;
   public $ISASegment = '';
   public $ISASegmentFilePos = -1;
   public $STSegmentFilePos = -1;
   public $SESegmentFilePos = -1;
   
   public $FShipmentMemo = array();
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //parent::__construct();
      
   }   
   
   
   
}



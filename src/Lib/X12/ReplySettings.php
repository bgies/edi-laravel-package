<?php

namespace Bgies\EdiLaravel\Lib\X12;

use Bgies\EdiLaravel\Lib\PropertyType;


class ReplySettings
{
   public bool $AcknowledgeFileOn997 = true;
   public bool $AcknowledgeTransactionOn997Accepted = false;
   public bool $AcknowledgeTransactionOn997Reject = true;
   public bool $AcknowledgeFileOn824 = true;
   public bool $AcknowledgeTransactionOn824Accepted = true;
   public bool $AcknowledgeTransactionOn824Reject = true;
   public string $ErrorSegment = '';
   public array $ErrorTransaction = array();
   public int $OnlyMatchControlNumberWithin = 0;
   public string $SQLCommand824 = '';
   public string $SQLCommand997 = '';

   public string $DetailQuery = '';
   public string $GESegment = '';
   public int $GESegmentFilePos = -1;
   public string $GSSegment = '';
   public int $GSSegmentFilePos = -1;
   public string $IEASegment = '';
   public int $IEASegmentFilePos = -1;
   public string $ISASegment = '';
   public int $ISASegmentFilePos = -1;
   public int $STSegmentFilePos = -1;
   public int $SESegmentFilePos = -1;
   
   public array $FShipmentMemo = array();
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //parent::__construct();
      
   }   
   
   public function getPropertyTypes() {
      $propTypes = array();
      $propTypes['AcknowledgeFileOn997'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['AcknowledgeTransactionOn997Accepted'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['AcknowledgeTransactionOn997Reject'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['AcknowledgeFileOn824'] = new PropertyType(
         'bool', 1, 1, false, true, null, true, true
         );
      $propTypes['AcknowledgeTransactionOn824Accepted'] = new PropertyType(
         'bool', 1, 1, false, true, null, true, true
         );
      $propTypes['AcknowledgeTransactionOn824Reject'] = new PropertyType(
         'bool', 1, 1, false, true, null, true, true
         );
      $propTypes['ErrorSegment'] = new PropertyType(
         'string', 0, 255, true, false, null, false, false
         );
      $propTypes['ErrorTransaction'] = new PropertyType(
         'array', 1, 255, true, false, null, false, false
         );
      $propTypes['OnlyMatchControlNumberWithin'] = new PropertyType(
         'int', 0, 30, false, true, null, true, true
         );
      $propTypes['SQLCommand824'] = new PropertyType(
         'textarea', 3, 255, false, true, null, true, true
         );
      $propTypes['SQLCommand997'] = new PropertyType(
         'textarea', 3, 255, false, true, null, true, true
         );
      $propTypes['DetailQuery'] = new PropertyType(
         'textarea', 4, 200, false, true, null, true, true
         );
      
      
/*      
      $this->propertyType = $propertyType;
      $this->minLength = $minLength;
      $this->maxLength = $maxLength;
      $this->allowNull = $allowNull;
      $this->required = $required;
      $this->dataElement = $dataElement;
      $this->canEdit = $canEdit;
      $this->displayInForm = $displayInForm; 
*/      
      
      $propTypes['GESegment'] = new PropertyType(
         'string', 1, 255, true, false, null, false, false
         );
      $propTypes['GESegmentFilePos'] = new PropertyType(
         'int', 0, 255, true, false, null, false, false
         );
      $propTypes['GSSegment'] = new PropertyType(
         'string', 1, 255, true, false, null, false, false
         );
      $propTypes['GSSegmentFilePos'] = new PropertyType(
         'int', 1, 255, true, false, null, false, false
         );
      $propTypes['IEASegment'] = new PropertyType(
         'string', 1, 255, true, false, null, false, false
         );
      $propTypes['IEASegmentFilePos'] = new PropertyType(
         'int', 1, 255, true, false, null, false, false
         );
      $propTypes['ISASegment'] = new PropertyType(
         'array', 1, 255, true, false, null, false, false
         );
      $propTypes['ISASegmentFilePos'] = new PropertyType(
         'int', 1, 255, true, false, null, false, false
         );
      $propTypes['STSegmentFilePos'] = new PropertyType(
         'int', 1, 255, true, false, null, false, false
         );
      $propTypes['SESegmentFilePos'] = new PropertyType(
         'int', 1, 255, true, false, null, false, false
         );
      $propTypes['FShipmentMemo'] = new PropertyType(
         'textarea', 1, 255, true, false, null, false, false
         );
      
      return $propTypes;
   }
   
}



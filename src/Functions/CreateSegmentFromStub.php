<?php

namespace Bgies\EdiLaravel\Functions;

//use lib\x12\SharedTypes;
use Bgies\EdiLaravel\Stubs\X12SendOptionsStub;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Doctrine\DBAL\ColumnCase;
use Bgies\EdiLaravel\Functions\CreateSegmentFromStub;


class CreateSegmentFromStub 
{
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      //parent::__construct();
      // construct the unique objects for this Option Object here
      // and set the default properties
      // such as $this->B3Options = new B3Options();
//      $this->ediStandard = $ediStandard;
//      $this->transactionSetName = $transactionSetName;
//      $this->isIncoming = $isIncoming;
   }
   
   public function getSrcDirectory() {
      $topDirectory =  __DIR__ ;
      $srcDir = dirname($topDirectory, 2) . '/src';
      return $srcDir;
   }
   
   
   /*
    * if we already have a Segment Type object for this segment, we
    * don't need to do anything except return a positive
    */
   public function CreateSegmentObject($segmentName, $extensionStr, $ediStandard, $isIncoming) : ReturnValues {
      $srcDir = $this->getSrcDirectory();
      $stubsDir = $srcDir . '/Stubs/';
      
      $retValues = new ReturnValues();
      
      
      switch ($ediStandard) {
         case 'X12' :
            if ($isIncoming == 1) {
               $segmentDir = $srcDir . '/Lib/X12/SegmentFunctions/Read/';
               $fullPath = $segmentDir . 'Segment' . $segmentName . $extensionStr . '.php';
               if (file_exists($fullPath)) {
                  $retValues->addToErrorList('Segment ' . $segmentName . $extensionStr . ' already exists. If you intend to create a duplicate, change the Extension Str');
                  return $retValues;
               }
               
               if (!file_exists($fullPath)) {
                  // if we don't have an available Segment file, create one from a stub
                  $retValues->addToMessages('A new Segment was created ' . $fullPath . ', but it needs programming to make it useful ');
                  
                  $stubFullName = $stubsDir . 'X12ReadSegmentStub.php';
                  $stubFileContent = file_get_contents($stubFullName, true);
                  
                  $segmentNameWithExtension = $segmentName . $extensionStr;
                  // do the replacing of strings in the stub file 
                  $stubFileContent = str_replace('{{SegmentName}}', $segmentName, $stubFileContent);
                  $stubFileContent = str_replace('{{SegmentNameWithExtension}}', $segmentNameWithExtension, $stubFileContent);
                  
                  $result = file_put_contents($fullPath, $stubFileContent);
               }
               $retValues->setResult(true);
            } else {
               $segmentDir = $srcDir . '/Lib/X12/SegmentFunctions/Send/';
               $fullPath = $segmentDir . 'Segment' . $segmentName . $extensionStr . '.php';
               if (!file_exists($fullPath)) {
                  $retValues->addToMessages('A new Segment File was created at ' . $fullPath . ', but it needs programming to make it useful ');
                 
                  $stubFullName = $stubsDir . 'X12SendSegmentStub.php';
                  $stubFileContent = file_get_contents($stubFullName, true);
                  $stubFileContent = str_replace('{{SegmentName}}', $segmentName, $stubFileContent);
                  
                  $result = file_put_contents($fullPath, $stubFileContent);
               }
               
            }
            break;
         case 'EDIFACT' :
            // do the EDIFACT stuff here.
            $retValues->addToErrorList('EDIFACT Segment is not implemented yet');
            
            break;
         default :
            $retValues->setResult(false);
            $retValues->addToErrorList('Unknown EDI Standard (' . $ediStandard . ')');
            
            break;
      }
      
      return $retValues;
   }
   
}
<?php

namespace Bgies\EdiLaravel\Alerts;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


/*
 * Email Alert is designed to send an email alert  
 * in real time when needed
 * 
 *  
 * NOTE - disk (oldDisk, moveFilesToDisk) refers to Laravel's 
 * disk system in the config/filesystems file. 
 * 
 */

class EmailAlert
{
   public bool $enabled = true;
   public string $sendToEmailAddress = '';
   

   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      LoggingFunctions::logThis('info', 3, 'Bgies\EdiLaravel\Alerts\EmailAlerts construct', 'Start');
   }
   
   public function execute(string $originalDisk, string $shortFileName, $EdiObj) {
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Alerts\EmailAlerts execute', 'Start');
      
      if ($EdiObj->isTestFile && !$EdiObj->testFileOptions->sendTestFile ) {
         return;
      }
      
      if (! $originalDisk) {
         throw new \Exception("FileDrop originalDisk is Blank");
         return false;
      }
      if (! $shortFileName) {
         throw new \Exception("FileDrop shortFileName is Blank");
         return false;
      }
      
      //$retVal = Storage::disk('edi')->makeDirectory($this->shortFileNameOnDisk);
      
      
   }
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      $propTypes['enabled'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['sendToEmailAddress'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'The email address to send the message to'
         );
/*      
      $propTypes['changeFileName'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['changeFileNameMask'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'The File Name to Use'
         );
*/      
      return $propTypes;
   }
   
   
   
}
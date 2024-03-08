<?php

namespace Bgies\EdiLaravel\Alerts;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


/*
 * SMS Alert is designed to send an email alert  
 * in real time when needed
 * 
 *  
 * NOTE - JUST A PLACEHOLDER FOR NOW. NOT IMPLEMENTED 
 * 
 */

class SmsAlert
{
   public bool $enabled = true;


   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      LoggingFunctions::logThis('info', 3, 'Bgies\EdiLaravel\Alerts\SmsAlerts construct', 'Start');
   }
   
   public function execute(string $originalDisk, string $shortFileName, $EdiObj) {
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Alerts\SmsAlerts execute', 'Start');
   
      
      
      
   }
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      $propTypes['enabled'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      /*
      $propTypes['sendToEmailAddress'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'The email address to send the message to'
         );
      
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


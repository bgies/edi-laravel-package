<?php

namespace Bgies\EdiLaravel\Functions;


use Illuminate\Support\Facades\Storage;



/**
 * @author bgies
 *
 */
class LoggingFunctions
{
   // Default LogLevel is 5, but it should be set in the .env file    
   public bool $isLogging = true;
   public bool $isSet = false;
   
   public static function logThis(string $LogType, int $Priority, string $fromProcedure, string $message) {
      
      
      //emergency, alert, critical, error, warning, notice, info and debug
      
      // if the Priority is greater than or equal to the LogLevel Log it, otherwise ignore it
      if ($Priority >= 10 - config('edilaravel.logLevel')) {
         switch ($LogType) {
            case 'debug' : {
               \Log::debug($fromProcedure . ' ' . $message);
               break;
            }
            case 'info' : {
               \Log::info($fromProcedure . ' ' . $message);
               break;
            }
            case 'notice' : {
               \Log::notice($fromProcedure . ' ' . $message);
               break;
            }
            case 'warning' : {
               \Log::warning($fromProcedure . ' ' . $message);
               break;
            }
            case 'error' : {
               \Log::error($fromProcedure . ' ' . $message);
               break;
            }
            case 'critical' : {
               \Log::critical($fromProcedure . ' ' . $message);
               break;
            }
            case 'alert' : {
               \Log::alert($fromProcedure . ' ' . $message);
               break;
            }
            case 'emergency' : {
               \Log::emergency($fromProcedure . ' ' . $message);
               break;
            }
            default : {
               \Log::info($fromProcedure . ' ' . $message);
               break;
            }
         }         
      };
      
   }

}
   

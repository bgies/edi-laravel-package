<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;

use Illuminate\Support\Facades\View;
use Bgies\EdiLaravel\Functions\LoggingFunctions;



class BladeFunctions 
{
    
    public static function showObject(string $parentObjectName, string $objName, object $inObj, int $indentLevel) {
       
       //\Log::info('BladeFunction showObject START parentObjectName: ' . $parentObjectName . '  objName: ' . $objName);
       $fieldType = gettype($inObj);  
       //\Log::info('BladeFunction showObject after gettype');
       if ($fieldType !== 'object') {
          if ($fieldType === 'string') {
             $inObj = unserialize($inObj);
          }
          
       }
       
       //if (View::exists('edilaravel::ediTypes.object')) {
       //   \Log::info('BladeFunction showObject View::exists');
       //}
       //\Log::info('BladeFunction showObject objName: ' . $objName);
       //\Log::info('BladeFunction showObject inObj: ' . print_r($inObj, true));
       //\Log::info('BladeFunction showObject indentLevel: ' . $indentLevel);
       
       $curObjectProperties = \Bgies\EdiLaravel\Functions\ObjectFunctions::getVars($inObj);
       //\Log::info('BladeFunction showObject curObjectProperties: ' . print_r($curObjectProperties, true));
       
       $data = [
          'parentObjectName' => $parentObjectName,
          'objName' => $objName,
          'inObj' => $inObj,
          'indentLevel' => $indentLevel          
       ];
       
       $html = View::make('edilaravel::ediTypes.object', $data);
       
       return $html;
    }
    
    
    
  
    
}
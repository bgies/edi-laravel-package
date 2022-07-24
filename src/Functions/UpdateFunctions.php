<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;

use Illuminate\Support\Facades\View;




class UpdateFunctions 
{
    
    public static function updateObjectProperty(object $inObj, string $objPropertyName, string $requestPropertyName, Array $propertyInfo) {
       
       \Log::info('UpdateFunction updateObjectProperty START objPropertyName: ' . $objPropertyName . '  objName: ' . $objName);
       $fieldType = gettype($inObj);  
    
       
    }
    
}
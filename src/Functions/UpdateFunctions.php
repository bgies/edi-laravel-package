<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;

use Illuminate\Support\Facades\View;




class UpdateFunctions 
{
   
   public static function valueHasChanged($originalElement, $newElement) {
      \Log::info('UpdateFunctions valueHasChanged START originalElement: ' . print_r($originalElement, true) . '  newElement: ' . print_r($newElement, true));
      if ($originalElement == $newElement) {
         return false;
      }
      
      return true;      
   }
      
   public static function verifyValue($propertyName, $newValue, $propertyInfo, Array &$errorList) {
      \Log::info('UpdateFunctions verifyValue START newValue: ' . print_r($newValue, true) . '  propertyInfo: ' . print_r($propertyInfo, true));
      $retVal = true;
      if ($propertyInfo->canEdit != 1) {
         $retVal = false; 
      }
      
      switch ($propertyInfo->propertyType) {
         case 'string':
            if (strlen($newValue) < $propertyInfo->minLength) {
               $errorList[] = $propertyName . ' must be a minimum of ' . $propertyInfo->minLength . ' characters';
               $retVal = false;
            }
            if (strlen($newValue) > $propertyInfo->maxLength) {
               $errorList[] = $propertyName . ' must be a maximum of ' . $propertyInfo->maxLength . ' characters';
               $retVal = false;
            }
            
         break;
         
         default:
               ;
         break;
      }
      
      
      return $retVal;
   }
   
/*
 * (
    [propertyType] => string
    [minLength] => 1
    [maxLength] => 1
    [allowNull] => 
    [required] => 1
    [dataElement] => 
    [canEdit] => 1
    [displayInForm] => 1
    [propertyHelp] => 
)
 */   
   
    public static function updateObjectProperty(object &$inObj, string $propertyName, string $propertyValue, Array $propertyInfo, Array $errorList) {
       \Log::info('UpdateFunctions updateObjectProperty START propertyName: ' . $propertyName);
       //\Log::info('updateObjectProperty propertyInfo: ' . print_r($propertyInfo, true) );
       $wasUpdated = false;
       $hasChanged = false;
       
       $explodedName = explode('_', $propertyName);
       \Log::info('updateObjectProperty explodedName: ' . print_r($explodedName, true) );
       
       $firstElementName = $explodedName[0];
       $firstProperty = $inObj->$firstElementName;
       \Log::info('updateObjectProperty firstProperty: ' . print_r($firstProperty, true) );
       
       if (count($explodedName) == 1) {
       
          $firstElementValue = $inObj->$firstElementName;
          $firstElementProperties = $propertyInfo[$firstElementName];
          \Log::info('updateObjectProperty firstElementProperties: ' . print_r($firstElementProperties, true) );
          
          $hasChanged = UpdateFunctions::valueHasChanged($firstElementValue, $propertyValue);
          \Log::info('updateObjectProperty 0 hasChanged: ' . print_r($hasChanged, true) );
          if ($hasChanged) {
             
             $firstLevelProperties = $propertyInfo[$propertyName]; 
             \Log::info('updateObjectProperty 0 firstLevelProperties: ' . print_r($firstLevelProperties, true) );
             $isValid = UpdateFunctions::verifyValue($propertyName, $propertyValue, $propertyInfo, $errorList);
             \Log::info('updateObjectProperty 1 isValid: ' . print_r($isValid, true) );
             if ($isValid) {
                $inObj->$firstElementName = $propertyValue;
                $wasUpdated = true;
             }             
          }          
       }
       
       
       if (count($explodedName) == 2) {
          $secondElementName = $explodedName[1];          
          $secondElementValue = $inObj->$firstElementName->$secondElementName; 
          \Log::info('updateObjectProperty 1 secondElementName: ' . $secondElementName . '  secondElementValue: ' . print_r($secondElementValue, true) );
          
          $hasChanged = UpdateFunctions::valueHasChanged($secondElementValue, $propertyValue);
          \Log::info('updateObjectProperty 1 hasChanged: ' . print_r($hasChanged, true) );
          if ($hasChanged) {
             $secondLevelProperties = $firstProperty->$secondElementName;
             \Log::info('updateObjectProperty 1 secondLevelProperties: ' . print_r($secondLevelProperties, true) );
//             $secondLevelObj = unserialize($inObj->$firstElementName);
             $secondLevelPropertyInfo = $inObj->$firstElementName->getPropertyTypes();
             \Log::info('updateObjectProperty 1 secondLevelPropertyInfo: ' . print_r($secondLevelPropertyInfo, true) );
             
             $elementPropertyInfo = $secondLevelPropertyInfo[$secondElementName];
             
             $isValid = UpdateFunctions::verifyValue($propertyName, $propertyValue, $elementPropertyInfo, $errorList);
             \Log::info('updateObjectProperty 1 isValid: ' . print_r($isValid, true) );
             if ($isValid) {
                $inObj->$firstElementName->$secondElementName = $propertyValue;
                $wasUpdated = true;
             }
             
          }          
       } 
       
       \Log::info('updateObjectProperty DONE wasUpdated: ' . $wasUpdated);
       
      return $wasUpdated; 
    }
    
}
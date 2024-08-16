<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;



class QueryFunctions 
{

   public static function setParams($query, $dataset, $parentDataSet = null) {
      if (!strpos($query, ':')) {
         return $query;
      }
      
      $i = 0;
      do {
         if (strpos($query, ':') > 1) {
            $colonPos = strpos($query, ':');
            $fieldName = trim(substr($query, $colonPos + 1));
            $spacePos = strpos($fieldName, ' '); 
            // if there is no space, this must be the last param. 
            if ($spacePos) {
               $fieldName = substr($fieldName, 0, $spacePos);
            }
            // if there's a comma at the end, strip it.
            $commaPos = strpos($fieldName, ',');
            $fieldLen = strlen($fieldName);
            if (strpos($fieldName, ',') + 1 == strlen($fieldName)) {
               $fieldName = substr($fieldName, 0, strlen($fieldName) -1);
            }
            if (strpos($fieldName, ')') + 1 == strlen($fieldName)) {
               $fieldName = substr($fieldName, 0, strlen($fieldName) -1);
            }
            
            if (array_key_exists($fieldName, $dataset)) {
               $paramValue = $dataset[$fieldName];
            } else {
               // if it doesn't exist in the current dataset, check the parent
               // if we have one. 
               if ($parentDataSet) {
                  if (array_key_exists($fieldName, $parentDataSet)) {
                     $paramValue = $parentDataSet[$fieldName];
                  }
                     
               } else {
                  throw new EdiFatalException("Field " . $fieldName . " was not found in Dataset");
               }
            }
            
            
            if (is_bool($paramValue)) {
               $val = $paramValue === true ? 'TRUE' : 'FALSE';
            } else if (is_numeric($paramValue)) {
               $val = $paramValue;
            } else {
               $val = "'$paramValue'";
            }

            $query = str_replace(':' . $fieldName, $val, $query);
         }
         
         
         
         $i++;
      } while (($i < 15) && strpos($query, ':') > 1);
      
      
      
      
      
      return $query; 
   }
   
   
   public static function populateQuery($query, $bindings) {
      
      foreach ($bindings as $binding) :
      
         if (is_bool($binding)) {
            $val = $binding === true ? 'TRUE' : 'FALSE';
         } else if (is_numeric($binding)) {
            $val = $binding;
         } else {
            $val = "'$binding'";
         }
      
         $query = preg_replace("#\?#", $val, $query, 1);
      endforeach;

      return $query;
   }
   


   function logger()
   {
    $queries = \Illuminate\Database\Capsule\Manager::getQueryLog();
    $formattedQueries = [];
    foreach ($queries as $query) :
        $prep = $query['query'];

        foreach ($query['bindings'] as $binding) :

            if (is_bool($binding)) {
                $val = $binding === true ? 'TRUE' : 'FALSE';
            } else if (is_numeric($binding)) {
                $val = $binding;
            } else {
                $val = "'$binding'";
            }

            $prep = preg_replace("#\?#", $val, $prep, 1);
        endforeach;
        $formattedQueries[] = $prep;
    endforeach;
    return $formattedQueries;
   }
   
}
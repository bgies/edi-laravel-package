<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;


class QueryFunctions 
{

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
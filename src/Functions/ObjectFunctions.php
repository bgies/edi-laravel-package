<?php

namespace Bgies\EdiLaravel\Functions;

use Carbon\Carbon;


class ObjectFunctions 
{
    
    public static function getObjectProperties($inObject) {
       $beforeProcessObjectProperties = [];
    
       if ($inObject) {
         $beforeProcessObjectProperties = get_class_vars(get_class($inObject));
       }
       
       return $beforeProcessObjectProperties;
    }
    
    public static function getMethods($inObject)
    {
       $objectProperties = [];
    
       if ($inObject) {
          $objectProperties = get_class_methods($inObject);
       }
       
       return $objectProperties;
    }

    public static function getVars($inObject) : array
    {
       $objectProperties = [];
       
       if ($inObject) {
          $objectProperties = get_object_vars($inObject);
       }
       
       return $objectProperties;
    }
    
    public static function breakFieldName($inStr) : string
    {
       $nameStrings = preg_split('/(?=[A-Z])/', $inStr, -1, PREG_SPLIT_NO_EMPTY); 
       //\Log::info('');
       //\Log::info('breakFieldName inStr: ' . $inStr . ' - ' . print_r($nameStrings, true));
       
       $wordString = '';
       $nameStringsCount = 0;
       for ($i = 0; $i < count($nameStrings); $i++) {
          //\Log::info('breakFieldName: ' . $inStr . ' - ' . $nameStrings[$i]);
          if ($nameStrings[$i] == 'S') {
             //\Log::info('breakFieldName if==S: ' . $inStr . ' - ' . $nameStrings[$i]);
             if (count($nameStrings) >= $i + 2 && $nameStrings[$i + 1] == 'Q' && $nameStrings[$i + 2] == 'L') {
               $wordString .= 'SQL ';
               $i = $i + 2;
             }
          } else {
             //\Log::info('breakFieldName else: ' . $inStr . ' - ' . $nameStrings[$i]);
             if (strcspn($nameStrings[$i], '0123456789') != strlen($nameStrings[$i])) {
                $numberPos = strcspn($nameStrings[$i], '0123456789');
                //\Log::info('breakFieldName else: ' . $inStr . ' - ' . $nameStrings[$i] . ' i: ' . $i . '  numberPos: ' . $numberPos );
                $wordString .= substr($nameStrings[$i], 0, $numberPos)  . ' ' ;
                $nameStrings[$i] = substr($nameStrings[$i], $numberPos);
                
                //\Log::info('breakFieldName wordString: ' . $wordString . ' - ' . $nameStrings[$i]);
                   
                if (is_numeric($nameStrings[$i])) {
                   $wordString .= substr($nameStrings[$i], 0, 1);
                   $nameStrings[$i] = substr($nameStrings[$i], 1);

                   if (is_numeric($nameStrings[$i])) {
                      $wordString .= substr($nameStrings[$i], 0, 1);
                      $nameStrings[$i] = substr($nameStrings[$i], 1);
                
                      if (is_numeric($nameStrings[$i])) {
                         $wordString .= substr($nameStrings[$i], 0, 1) . ' ';
                         $nameStrings[$i] = substr($nameStrings[$i], 1);
                      } else {
                         $wordString .= ' ';
                      }
                   } else {
                      $wordString .= ' ';
                   }
                }

                if (strlen($nameStrings[$i]) >= $i + 2 && is_numeric($nameStrings[$i][$numberPos + 1]) && is_numeric($nameStrings[$i][$numberPos + 2]) ) {
                   \Log::info('breakFieldName 3 Digits wordString: ' . $wordString . ' - ' . $nameStrings[$i]);
                   $wordString .= ' ' . substr($nameStrings[$i], 0, $numberPos) . ' ' . substr($nameStrings[$i], $numberPos);
                   $i = $i + 2;
                }
             } else {
                if (count($nameStrings) >= $i + 1 &&  $nameStrings[$i] == 'G' && $nameStrings[$i+1] == 'S' ) {
                   $wordString .= 'GS ';
                   $i = $i + 1;
                } else {
                
                  $wordString .= $nameStrings[$i] . ' ' ;
                }
             }
          }
          
       }
       
       $wordString = trim($wordString);
       
       $wordString = ucwords($wordString);   
       //\Log::info('breakFieldName: ' . $inStr . ' - ' . print_r($wordString, true));
       return print_r($wordString, true);
    }
    
    public static function is_serialized( $data, $strict = true ) {
       // If it isn't a string, it isn't serialized.
       if ( ! is_string( $data ) ) {
          return false;
       }
       $data = trim( $data );
       if ( 'N;' === $data ) {
          return true;
       }
       if ( strlen( $data ) < 4 ) {
          return false;
       }
       if ( ':' !== $data[1] ) {
          return false;
       }
       if ( $strict ) {
          $lastc = substr( $data, -1 );
          if ( ';' !== $lastc && '}' !== $lastc ) {
             return false;
          }
       } else {
          $semicolon = strpos( $data, ';' );
          $brace     = strpos( $data, '}' );
          // Either ; or } must exist.
          if ( false === $semicolon && false === $brace ) {
             return false;
          }
          // But neither must be in the first X characters.
          if ( false !== $semicolon && $semicolon < 3 ) {
             return false;
          }
          if ( false !== $brace && $brace < 4 ) {
             return false;
          }
       }
       $token = $data[0];
       switch ( $token ) {
          case 's':
             if ( $strict ) {
                if ( '"' !== substr( $data, -2, 1 ) ) {
                   return false;
                }
             } elseif ( false === strpos( $data, '"' ) ) {
                return false;
             }
             // Or else fall through.
          case 'a':
          case 'O':
             return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
          case 'b':
          case 'i':
          case 'd':
             $end = $strict ? '$' : '';
             return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
       }
       return false;
    }
    
}
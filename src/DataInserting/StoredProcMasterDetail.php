<?php

namespace Bgies\EdiLaravel\DataInserting;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Functions\QueryFunctions;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;
use App\Exceptions\EdiException;

class StoredProcMasterDetail
{
   
   public string $masterProcedureName = '';
   public string $detailProcedureName = '';
   public bool $useSubDetail = false;
   public string $subDetailProcedureNames = '';
   public string $subDetailFieldNames = ''; // if there are multiple sub detail fields use : to separate
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      
      
   }
   
   
   public function execute($dataset = null, $ediOptions): array
   {
      if (! $this->masterProcedureName) {
         throw new EdiDbException("Stored Procedure Name is Blank");
         return false;
      }
      \Log::info('Bgies\EdiLaravel\DataHandling\StoredProcedureMasterDetail execute START');

      if (! $dataset) {
         throw new EdiDbException("dataset is not assigned");
         return false;
      }
      
      if (! $ediOptions) {
         throw new EdiDbException("ediOptions is not assigned");
         return false;
      }
      
      //$procNameStr = "CALL " . $this->masterProcedureName;
      // if there are no params
      if ( ! strpos($this->masterProcedureName, ':') > 0) {
         $masterResults = \DB::select( $procNameStr );
      }

      try {
         $masterQuery = QueryFunctions::setParams($this->masterProcedureName, $dataset);
         $procNameStr = "CALL " . $masterQuery;
         //$dbResults = \DB::select(\DB::raw( $procNameStr ));
         $masterResults = \DB::select( $procNameStr );
         
      }
      catch (EdiFatalException | EdiException $e) {
         throw $e;
      }
      catch (Exception $e) {
         throw $e;
      }
      
      $dbResults[] = $masterResults[0];
      
      // now call the Detail Proc (if there is one once 
      // for each detail record
      if (array_key_exists('DetailDataSet', $dataset)) {
      
         foreach ($dataset['DetailDataSet'] as $detailRecord) {
            try {
               $detailQuery = QueryFunctions::setParams($this->detailProcedureName, $detailRecord, $dataset);
               $procNameStr = "CALL " . $detailQuery;
               //$dbResults = \DB::select(\DB::raw( $procNameStr ));
               $detailDbResults = \DB::select( $procNameStr );
               
               if ( ! array_key_exists('DetailResults', $dbResults)) {
                  $dbResults['DetailResults'] = [];
               }
               $dbResults['DetailResults'][] = $detailDbResults[0];
               
            
               if ($this->useSubDetail) {
               
               
               
               
               }
            
            }
            catch (EdiFatalException | EdiException $e) {
               throw $e;
            }
            catch (Exception $e) {
               throw $e;
            }
         }
         
      }      
      
      return $dbResults;
      
   }
   
   public function getPropertyTypes() {
      // $propTypes = parent::getPropertyTypes();
      $propTypes = [];
      
      $propTypes['masterProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      $propTypes['detailProcedureName'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      $propTypes['useSubDetail'] = new PropertyType(
         'bool', 0, 255, true, false, null, true, true, 'Use another loop to enter sub details'
         );
      $propTypes['subDetailProcedureNames'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure for sub Detail Loops'
         );
      $propTypes['subDetailFieldNames'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'Name of Stored Procedure to Execute'
         );
      
      
      return $propTypes;
   }
   
   
   
}
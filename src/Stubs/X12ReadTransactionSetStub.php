<?php

namespace Bgies\EdiLavavel\Lib\X12\TransactionSets\Read;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiReceive;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;



class X12Read{{TransactionSetName}} extends BaseEdiReceive
{
   public $transactionSetName = '{{TransactionSetName}}';
   
   /*** Full definition of procedure*/
   
   protected $proc = '';
   /*** Input parameters in procedure which can be null*/
   protected $canBeNull = [];
   /***  Result Set Mapping*/
   protected $resultSetMapping = [];
   
   public function defineFunctionName(array $inputParameter = [], array $resultSetMapping = [])
      {
         $rsm = $this->setResultSetMapping($resultSetMapping);
         $nativeQuery = $this->entityManager->createNativeQuery(
            $this->genProQuery($this->proc), $rsm);
         // set input parameter and execute query
         
   }
}
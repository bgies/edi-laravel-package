<?php

namespace Bgies\EdiLaravel\;

use Bgies;

use App\Procedure\AbstractDataLayer;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\DBALException;

class DummyClass extends AbstractDataLayer
{
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
<?php

namespace Bgies\EdiLaravel\Lib;

//declare(strict_types=1);

//use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


class ReturnValues
{
   private bool $retResult;
   private array $errorList;
   private array $messages;
   private array $retPairs;

   public function __construct()
   {
      $this->retResult = false;
      $this->errorList = [];
      $this->messages = [];
      $this->retPairs = [];
   }
   
   public function setResult(bool $retResult) {
      $this->retResult = $retResult;
   }
   
   public function getResult() {
      return $this->retResult;   
   }
   
   public function addToErrorList(string $incomingError) {
      $this->errorList[] = $incomingError;
   }
   
   public function addToMessages(string $incomingMessage) {
      $this->messages[] = $incomingMessage;
   }
   
   public function addToRetPairs(string $name, $value) {
      $this->retPairs[$name] = $value;
   }

   public function getErrorCount() {
      return count($this->errorList);
   }

   public function getMessageCount() {
      return count($this->messages);
   }
   
   public function getRetPairsCount() {
      return count($this->retPairs());
   }
   
   public function getErrorList(): array {
      return $this->errorList;
   }
   
   public function getMessages(): array {
      return $this->messages;
   }

   public function getRetPairs(): array {
      return $this->retPairs;
   }
   
}
   
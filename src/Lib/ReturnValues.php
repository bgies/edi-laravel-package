<?php

namespace Bgies\EdiLaravel\Lib;

//declare(strict_types=1);

//use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


class ReturnValues
{
   
   private array $errorList;
   private array $messages;

   public function __construct()
   {
      $this->errorList = [];
      $this->messages = [];
   }
   
   public function addToErrorList(string $incomingError) {
      $this->errorList[] = $incomingError;
   }
   
   public function addToMessages(string $incomingMessage) {
      $this->messages[] = $incomingMessage;
   }
   
   public function getErrorList(): array {
      return $this->errorList;
   }
   
   public function getMessages(): array {
      return $this->messages;
   }
   
}
   
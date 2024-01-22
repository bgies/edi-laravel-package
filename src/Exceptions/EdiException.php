<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use App\Exceptions\Handler;

class EdiException extends Exception
{
   public $exception;
   public $message;
   
   // see vendor/laravel//cashier/src/Exceptions/IncompletePayment.php
   public function __construct($message = '', $code = 0, Throwable $previous = null)
   {
      $this->message = $message;
      parent::__construct($message, $code, $previous);
   }
   
   
/*   
   public function __construct(Exception $e)
   {
      $this->exception = $e;
      parent::__construct($e->getError()->message, $e->getCode(), null);
   }
*/   
   /**
    * Report the exception.
    *
    * @return void
    */
   public function report()
   {
      \Log::error('EDIException');
      $e = $this->exception;
      \Log::error('EDI Exception : ' .
         ' Message is:' . $e->getMessage() .
         ' Status is:' . $e->getHttpStatus() .
         ' Type is:' . $e->getError()->type .
         ' Code is:' . $e->getError()->code .
         ' Param is:' . $e->getError()->param .
         ' Message is:' . $e->getError()->message
         );
      
      
   }
   
  
}

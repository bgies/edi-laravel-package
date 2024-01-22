<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use App\Exceptions\Handler;

class EdiFatalException extends Exception
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
      \Log::error('EDIFatalException');
      $e = $this->exception;
      \Log::error('EDI Fatal Exception : ' .
         ' Message is:' . $this->message . // $e->getMessage() .
//         ' Status is:' . $this->getHttpStatus() .
         ' File:' . $this->file .
         ' Line: ' . $this->line 
//         ' Trace is:' . $this->getError()->param 
         );
      
      
   }
   
  
}

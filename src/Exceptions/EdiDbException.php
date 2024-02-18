<?php

namespace Bgies\EdiLaravel\Exceptions;

use Throwable;
use Exception;
use App\Exceptions\Handler;

class EdiDbException extends Exception
{
   public $exception;
   public $message;
   
   public function __construct($message = '', $code = 0, Throwable $previous = null)
   {
      $this->message = $message;
      parent::__construct($message, $code, $previous);
   }
   
   
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

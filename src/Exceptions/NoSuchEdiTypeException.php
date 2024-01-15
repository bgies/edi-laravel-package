<?php

namespace Bgies\EdiLaravel\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class NoSuchEdiTypeException extends Exception
{

    public function render(Request $request): Response
    {
        $status = 400;
        $error = "No Such EDI Type";
        $help = "The EDI Type does not exist";

        return response(["error" => $error, "help" => $help], $status);
    }
}


<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class UrlException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::debug('There is an issue in URL');
    }
}

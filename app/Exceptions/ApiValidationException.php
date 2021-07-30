<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\JsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiValidationException extends Exception
{
    use JsonResponseTrait;
    
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render()
    {
        return $this->jsonResponse(422, 'Invalid Data Provided', $this->errors, null);
    }
}

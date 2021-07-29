<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait JsonResponseTrait
{
    // Return Structured API Json Response
    public function jsonResponse($status, $message = '', $errors = null, $data = null): JsonResponse
    {
        return response()->json([
            'status'        => $status,
            'message'       => $message,
            'errors'        => $errors,
            'data'          => $data
        ]);
    }
}

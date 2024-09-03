<?php

namespace App\Exceptions;

use Exception;
use Laravel\Passport\Exceptions\AuthenticationException;

class Handler extends Exception
{
    // Other methods...

    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 401,
                    'description' => 'Unauthorized',
                    'message' => 'Unauthenticated. Please provide a valid token.'
                ], 401);
            }
        }

        return parent::render($request, $exception);
    }
}

<?php


if (!function_exists('respond')) {
    function respond($statusCode = 200, $message = null, $data = null)
    {
        $statusText = getStatusText($statusCode);
        $finalStatusCode = isset(listOfErrors()[$statusCode]) ? $statusCode : 500;

        $response = [
            'status' => $finalStatusCode,
            'description' => $statusText,
            'message' => $message
        ];

        if (!is_null($data)) {
            if (isset($data['error_code'])) {
                $response['error_code'] = $data['error_code'];
            } else {
                if (count($data) > 0) {
                    $response['data'] = $data;
                }
            }
        }
        return response()->json($response, $finalStatusCode);
    }
}

if (!function_exists('success')) {
    function success($message = null, $data = null, $statusCode = 200)
    {
        return respond($statusCode, $message, $data);
    }
}

if (!function_exists('notFound')) {
    function notFound($message = 'Not Found', $data = null)
    {
        return respond(404, $message, $data);
    }
}

if (!function_exists('badRequest')) {
    function badRequest($message = 'Bad Request', $data = null)
    {
        return respond(400, $message, $data);
    }
}

if (!function_exists('error')) {
    function error($errorMessage, $statusCode = 500, $data = null)
    {
        return respond($statusCode, $errorMessage, $data);
    }
}

if (!function_exists('getStatusText')) {
    function getStatusText($statusCode)
    {
        $statusTexts = listOfErrors();

        return $statusTexts[$statusCode] ?? 'Unknown';
    }
}

if (!function_exists('listOfErrors')) {
    function listOfErrors()
    {
        $httpErrors = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            // Add more status codes and texts as needed
        ];

        return $httpErrors;
    }
}

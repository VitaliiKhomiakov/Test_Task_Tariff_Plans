<?php

declare(strict_types=1);

namespace System\Error;

use System\Http\Response;

final class ErrorHandler
{
    public function handle(\Throwable $exception): void
    {
        http_response_code(Response::CODE_SERVER_ERROR);
        
        $errorMessage = \Config::DEBUG 
            ? $exception->getMessage() 
            : 'Internal Server Error';
            
        echo json_encode(['error' => $errorMessage]);
    }
}

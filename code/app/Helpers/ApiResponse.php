<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Facade;
use Pagination;

class ApiResponse extends Facade
{
    public function success($code = 200, $data = [], $message = 'Successful')
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public function error($code = 400, $errors = [], $message = '')
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ], $code);
    }
}

<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'api.response';
    }
}

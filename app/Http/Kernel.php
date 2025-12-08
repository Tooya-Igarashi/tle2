<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AdminMiddleware;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'admin' => AdminMiddleware::class,
    ];
}

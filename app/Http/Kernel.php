<?php
namespace App\Http\kernel;

protected $routeMiddleware = [
    // Otros middlewares...
    'role' => \App\Http\Middleware\CheckRole::class,
];
<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:dashboard-list', only: ['index']),
        ];
    }

    public function index()
    {
        return "hello";
    }
}

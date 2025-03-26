<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class HealthCheckController extends Controller
{
    public function check()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();
            $dbStatus = 'OK';
        } catch (\Exception $e) {
            $dbStatus = 'ERROR';
        }

        return response()->json([
            'status' => 'OK',
            'database' => $dbStatus,
            'cache' => Cache::getStore() ? 'OK' : 'ERROR',
            'timestamp' => now(),
        ]);
    }
}

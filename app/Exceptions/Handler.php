<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Exception $e, Request $request) {
            // Check if it's an API request and return a 500 response
            if ($request->is('api/*')) {
                Log::error($e->getMessage(), [
                    'exception' => $e,
                    'request' => $request->all(),
                ]);
                
                // Return a 500 response with a custom error message if anything goes wrong, standardised error responses
                return response()->json([
                    'error' => 'Something went wrong. Please try again later.',
                    'message' => $e->getMessage(),
                ], 500);
            }
        });
    }
}

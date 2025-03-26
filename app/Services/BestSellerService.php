<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BestSellerService
{
    /**
     * Fetch the best sellers list from the New York Times API.
     */
    public function fetchBestSellers($params)
    {
        $apiUrl = config('services.nyt.api_url').'/lists/best-sellers/history.json';
        $apiKey = config('services.nyt.api_key');

        try {
            // exponential backoff
            $response = Http::retry(3, 200, function ($exception) {
                return $exception instanceof \Illuminate\Http\Client\RequestException;
            })
            ->timeout(10)  // Timeout after 10 seconds if the request doesn't complete
            ->get($apiUrl, array_merge($params, ['api-key' => $apiKey]));

            if ($response->successful()) {
                return $response->json();
            }

            // Error handling
            throw new \Exception('Failed to fetch data from the New York Times API');
        } catch (\Exception $e) {
            Log::error('Error fetching Best Sellers', [
                'error' => $e->getMessage(),
                'params' => $params,
            ]);

            // Error handling
            return response()->json([
                'error' => 'Failed to fetch the best sellers list. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BestSellerRequest;
use App\Http\Resources\BestSellerResource;
use App\Services\BestSellerService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class BestSellerController extends Controller
{
    protected BestSellerService $bestSellerService;

    public function __construct(BestSellerService $bestSellerService)
    {
        $this->bestSellerService = $bestSellerService;
    }

    public function index(BestSellerRequest $request): JsonResponse
    {
        $queryParams = $request->validated();
        $cacheKey = 'nyt_best_sellers_' . md5(json_encode($queryParams));
        
        // if ($request->query('cache', 'true') !== 'false') {
        //     $data = Cache::remember($cacheKey, 3600, function () use ($queryParams) {
        //         return $this->bestSellerService->fetchBestSellers($queryParams);
        //     });
        // } else {
            $data = $this->bestSellerService->fetchBestSellers($queryParams);
        // }
        if (!$data || !is_array($data)) {
            return response()->json([
            'error' => 'Something went wrong. Please try again later.',
            'message' => 'Internal server error',
        ], 500);
        }
        
        return response()->json([
            'timestamp' => now(),
            'cache' => Cache::has($cacheKey),
            'data' => BestSellerResource::collection(collect($data['results'] ?? [])),
        ]);
    }
}


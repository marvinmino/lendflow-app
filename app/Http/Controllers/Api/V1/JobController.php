<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Exception;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Start the background job.
     */
    public function startJob(): JsonResponse
    {
        try {
            // Start the job and get the job ID
            $jobId = $this->jobService->startJob();

            // If there's an error starting the job, it would have been handled in the service.
            if (is_array($jobId) && isset($jobId['error'])) {
                return response()->json($jobId, 500);
            }

            return response()->json([
                'job_id' => $jobId,
                'message' => 'Job started, check status using /api/job-status/{job_id}',
            ], 202);
        } catch (Exception $e) {
            // Log the error and return a 500 response
            return response()->json([
                'error' => 'Failed to start the job. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check job status.
     */
    public function checkJobStatus($jobId): JsonResponse
    {
        try {
            $status = $this->jobService->checkJobStatus($jobId);

            // If the status is a JSON response (error), return it
            if (is_array($status) && isset($status['error'])) {
                return response()->json($status, 404);
            }

            return response()->json([
                'job_id' => $jobId,
                'status' => $status,
            ]);
        } catch (Exception $e) {
            // Log the error and return a 500 response
            return response()->json([
                'error' => 'Failed to retrieve job status. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Services;

use App\Jobs\DelayedSuccessJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class JobService
{
    /**
     * Start the background job and return job ID.
     *
     * @return string
     */
    public function startJob()
    {
        try {
            $jobId = Str::uuid()->toString();

            Cache::put("job_status:{$jobId}", 'processing', now()->addMinutes(5));

            DelayedSuccessJob::dispatch($jobId);

            return $jobId;
        } catch (Exception $e) {
            // Log the error and return a failure response
            Log::error("Error starting the job: " . $e->getMessage());

            return response()->json([
                'error' => 'Failed to start the job. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check the status of the job.
     *
     * @param string $jobId
     * @return string
     */
    public function checkJobStatus($jobId)
    {
        try {
            $status = Cache::get("job_status:{$jobId}", null);

            if (!$status) {
                return response()->json([
                    'error' => 'Job not found.',
                    'message' => "Job with ID {$jobId} does not exist or has expired.",
                ], 404);
            }

            return $status;
        } catch (Exception $e) {
            Log::error("Error checking job status: " . $e->getMessage());

            return response()->json([
                'error' => 'Failed to check job status. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

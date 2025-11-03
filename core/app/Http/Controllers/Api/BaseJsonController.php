<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class BaseJsonController extends Controller
{
    protected string $fileName;

    /**
     * Read and cache JSON data file.
     */
    protected function getData(): array
    {
        return Cache::rememberForever($this->fileName, function () {
            $path = database_path("data/{$this->fileName}.json");

            if (!file_exists($path)) {
                abort(404, "Data file not found: {$this->fileName}");
            }

            return json_decode(file_get_contents($path), true);
        });
    }

    /**
     * Standard success response.
     */
    protected function sendResponse(
        array $data,
        string $message = 'Successfully retrieved data.'
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'count' => count($data),
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Standard error response.
     */
    protected function sendError(string $message, int $status = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => [],
            'message' => $message,
            'count' => 0,
            'timestamp' => now()->toISOString(),
        ], $status);
    }
}

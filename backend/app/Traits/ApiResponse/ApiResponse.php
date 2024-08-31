<?php

namespace App\Traits\ApiResponse;

use Carbon\Carbon;
use App;

trait ApiResponse
{
    /**
     * Generate a success response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(string $message, $data = null, int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate a success created response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */

    protected function successCreatedResponse(string $message, $data = null, int $statusCode = 201)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate a failed response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'code' => $statusCode,
            'message' => $message,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $statusCode,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate a validation error response.
     *
     * @param array $errors
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse(array $errors, int $statusCode = 422)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $errors,
            'code' => $statusCode,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate a resource not found response.
     *
     * @param string $resource
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function resourceNotFoundResponse(string $resource, int $statusCode = 404)
    {
        return response()->json([
            'success' => false,
            'message' => "$resource not found",
            'code' => $statusCode,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    /**
     * Generate an unauthorized response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized', int $statusCode = 401)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $statusCode,
            'team' => 'Mec@team',
        ], $statusCode);
    }

    protected function kdProfile()
    {
        $profile = \App\Models\Profile\Profile::first();
        return $profile->kdprofile;
    }

    protected function statusEnabled()
    {
        return '1';
    }

    private function calculateAge($birthdate)
    {
        return Carbon::parse($birthdate)->age;
    }
}

<?php
namespace App\Services;

class ApiResponseService 
{
    public static function sendResponse($result, $message, $code)
    {
        return response()->json([
            'success' => true,
            'result' => $result,
            'message' => $message,
        ], $code);
    }

    public static function sendError($message, $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
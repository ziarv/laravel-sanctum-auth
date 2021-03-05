<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    protected function respondSuccess($message = 'success', $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function respondValidationError($messages)
    {
        throw ValidationException::withMessages($messages);
    }
}

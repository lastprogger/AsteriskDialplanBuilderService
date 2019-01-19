<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

abstract class AbstractApiController extends Controller
{
    /**
     * @param array  $data
     * @param string $message
     * @param int    $code
     * @param string $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond(array $data = [], string $message = '', int $code = 200, string $errorCode = '')
    {
        $data = [
            'data' => $data,
            'meta' => [
                'code'       => $code,
                'message'    => $message,
                'error_code' => $errorCode,
            ],
        ];

        return response()->json($data, $code);
    }

    /**
     * @param array  $data
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk(array $data = [], string $message = 'ok')
    {
        return $this->respond($data, $message, Response::HTTP_OK);
    }

    /**
     * @param string $message
     * @param int    $code
     * @param string $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError(string $message, int $code, string $errorCode = '')
    {
        return $this->respond([], $message, $code, $errorCode);
    }

    /**
     * @param string $message
     * @param string $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound(string $message = 'Model not found', string $errorCode = '')
    {
        return $this->respondWithError($message, Response::HTTP_NOT_FOUND, $errorCode);
    }

    /**
     * @param string $message
     * @param string $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondForbidden(string $message = 'Forbidden', string $errorCode = '')
    {
        return $this->respondWithError($message, Response::HTTP_FORBIDDEN, $errorCode);
    }

    /**
     * @param string $message
     * @param string $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError(string $message = 'Internal server error', string $errorCode = '')
    {
        return $this->respondWithError($message, Response::HTTP_INTERNAL_SERVER_ERROR, $errorCode);
    }
}
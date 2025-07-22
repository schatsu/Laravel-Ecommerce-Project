<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait Responder
{
    /**
     * Return a success JSON response.
     *
     * @param object|array|null $data
     * @param  int  $code
     * @return JsonResponse
     */
    protected function success(object|array|null $data, int $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        $response = [
            'status' => $code,
            'success' => true,
        ];
        if ($data instanceof JsonResource) {
            return $data->additional(array_merge($data->additional, $response))->toResponse(request());
        }
        return response()->json(array_merge($response, ['data' => $data]), $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $code
     * @param null $data
     * @return JsonResponse
     */
    protected function error(string $message, int $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
            'data' => $data
        ], $code);
    }
}

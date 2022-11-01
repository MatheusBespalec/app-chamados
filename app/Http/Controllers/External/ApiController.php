<?php

namespace App\Http\Controllers\External;

use App\Helpers\HttpHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Default response for External Controllers
     *
     * @param array $data
     * @param integer $httpStatus
     * @param array $headers
     * @return JsonResponse
     */
    protected function response(array $data = [], int $httpStatus = 200, array $headers = []): JsonResponse
    {
        return response()->json(array_merge(
            $data,
            [
                'response' => [
                    'code' => array_key_exists($httpStatus, HttpHelper::$listOfStatus)
                        ? $httpStatus
                        : null,
                    'message' => HttpHelper::$listOfStatus[$httpStatus]
                ]
            ]),
            $httpStatus,
            $headers
        );
    }
}

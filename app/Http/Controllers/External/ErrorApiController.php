<?php

namespace App\Http\Controllers\External;

use App\Http\Requests\ErrorRequest;
use App\Models\CustomerProject;
use App\Repositories\ErrorRepository;
use App\Entities\ErrorEntity;
use App\Entities\LogEntity;

class ErrorApiController extends ApiController
{
    public function __invoke(ErrorRepository $repository, ErrorRequest $request)
    {
        $errorEntity = new ErrorEntity($request->error_data);
        $logEntity = new LogEntity($request->request_data);

        $pivot = CustomerProject::query()->whereUuid($request->uuid)->with(['customer', 'project'])->first();
        $repository->insertOrUpdate($errorEntity, $logEntity, $request->route, $pivot->customer, $pivot->project);
        return $this->response(httpStatus: 204);
    }
}

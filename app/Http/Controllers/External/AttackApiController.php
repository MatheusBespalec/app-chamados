<?php

namespace App\Http\Controllers\External;

use App\Entities\AttackEntity;
use App\Models\CustomerProject;
use App\Repositories\AttackRepository;
use App\Entities\LogEntity;
use App\Http\Requests\AttackRequest;

class AttackApiController extends ApiController
{
    public function __invoke(AttackRepository $repository, AttackRequest $request)
    {
        $attackEntity = new AttackEntity($request->attack_data);
        $logEntity = new LogEntity($request->request_data);

        $pivot = CustomerProject::query()->whereUuid($request->uuid)->with(['customer', 'project'])->first();
        $repository->insertOrUpdate($attackEntity, $logEntity, $pivot->project, $pivot->customer);
        return $this->response(httpStatus: 204);
    }
}

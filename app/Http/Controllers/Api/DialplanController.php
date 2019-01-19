<?php


namespace App\Http\Controllers\Api;


use App\Domain\Service\DialplanBuilders\DialplanBuilder;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use App\Domain\Service\DialplanBuilders\Exceptions\DialplanBuildException;
use App\Domain\Service\DialplanBuilders\Exceptions\StoreDialplanException;
use App\Http\Requests\Dialplan\CreateDialplanRequest;
use Illuminate\Support\Facades\Log;

class DialplanController extends AbstractApiController
{
    public function store(
        CreateDialplanRequest $request,
        DialplanStoreService $dialplanStoreService
    ) {
        $dialplanBuilder = new DialplanBuilder($request->toArray());

        try {
            $dialplan = $dialplanBuilder->build();

            $dialplanStoreService->storeDialplan(
                $request->getCompanyId(),
                $request->getPbxId(),
                $request->getPbxSchemeId(),
                $dialplan
            );

            return $this->respondOk();

        } catch (DialplanBuildException|StoreDialplanException $e) {
            Log::error($e);
            return $this->respondInternalError($e->getMessage());
        }
    }
}
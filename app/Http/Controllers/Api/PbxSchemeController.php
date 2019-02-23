<?php


namespace App\Http\Controllers\Api;


use App\Domain\Models\PbxScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class PbxSchemeController extends AbstractApiController
{
    public function index(): JsonResponse
    {
        $pbxSchemeList = PbxScheme::all();
        return $this->respondOk($pbxSchemeList->toArray());
    }
    /**
     * @param string $apiVersion
     * @param string $pbxId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByPbxId(string $apiVersion, string $pbxId): JsonResponse
    {
        if(!Uuid::isValid($pbxId)){
            return $this->respondWithError('Bad PbxId', Response::HTTP_BAD_REQUEST);
        }

        $pbxScheme = PbxScheme::query()->where('pbx_id', $pbxId)->first();

        if($pbxScheme === null){
            return $this->respondNotFound();
        }

        return $this->respondOk($pbxScheme->toArray());
    }
}
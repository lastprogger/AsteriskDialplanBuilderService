<?php

namespace App\Domain\Service;

use App\Domain\Models\ExtensionsStorage;
use App\Domain\Service\Exceptions\NoFreeExtensionsForReserve;
use Illuminate\Support\Facades\DB;

class ExtensionStorageService
{
    /**
     * @param string $pbxSchemeId
     *
     * @return string
     * @throws NoFreeExtensionsForReserve
     */
    public function allocateOne(string $pbxSchemeId): string
    {
        DB::beginTransaction();

        $extenStorage = ExtensionsStorage::query()
                                         ->where('free', true)
                                         ->limit(1)
                                         ->lockForUpdate()
                                         ->first();

        if ($extenStorage === null) {
            throw new NoFreeExtensionsForReserve();
        }

        $extenStorage->pbx_scheme_id = $pbxSchemeId;
        $extenStorage->free = false;
        $extenStorage->save();
        DB::commit();

        return $extenStorage->exten;
    }

    /**
     * @param string $exten
     */
    public function releaseReserve(string $exten): void
    {
        $extenStorage = ExtensionsStorage::query()->where('exten', $exten)->first();
        $extenStorage->pbx_scheme_id = null;
        $extenStorage->free = true;
        $extenStorage->save();
    }

    /**
     * @param string[] $extenList
     */
    public function releaseReserveMany (array $extenList): void
    {
        $extenStorageList = ExtensionsStorage::query()->whereIn('exten', $extenList)->get();
        $extenStorageList->each(function (ExtensionsStorage $extenStorage) {
            $extenStorage->pbx_scheme_id = null;
            $extenStorage->free = true;
            $extenStorage->save();
        });
    }
}
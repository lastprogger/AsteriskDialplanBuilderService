<?php

namespace App\Domain\Service;

use App\Domain\Models\Extension;
use App\Domain\Models\PbxScheme;

class SwitchPbxSchemeService
{
    /**
     * @var ExtensionStorageService
     */
    private $extensionsStorage;

    /**
     * @param ExtensionStorageService $extensionStorageService
     */
    public function __construct(ExtensionStorageService $extensionStorageService)
    {
        $this->extensionsStorage = $extensionStorageService;
    }

    /**
     * @param string $pbxScheme
     */
    public function deletePbx(string $pbxId): void
    {
        $pbxScheme = PbxScheme::query()->where('pbx_id', $pbxId)->first();
        if ($pbxScheme === null) {
            return;
        }
        $extensions = Extension::query()->where('pbx_scheme_id', $pbxScheme->pbx_scheme_id)->get();
        $this->extensionsStorage->releaseReserveMany(
            $extensions->pluck('exten')->toArray()
        );
        foreach ($extensions as $extension) {
            $extension->forceDelete();
        }
        $pbxScheme->forceDelete();
    }
}
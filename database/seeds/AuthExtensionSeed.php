<?php

use App\Domain\Service\Dialplan\PresetExtensions\AuthExtensionPreset;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use Illuminate\Database\Seeder;

class AuthExtensionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeService = new DialplanStoreService();
        $storeService->storeExtension('auth', new AuthExtensionPreset());
    }
}

<?php

use App\Domain\Service\Dialplan\PresetExtensions\BootstrapExtensionPreset;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use Illuminate\Database\Seeder;

class BootstrapExtensionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeService = new DialplanStoreService();
        $storeService->storeExtension('bootstrap', new BootstrapExtensionPreset());
    }
}

<?php


namespace Tests\Feature\Service\ExtensionPresets;


use App\Domain\Models\Extension;
use App\Domain\Service\Dialplan\PresetExtensions\BootstrapExtensionPreset;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BootstrapExtensionPresetTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreBootstrapExtensionPresetAssertSuccess()
    {
        $storeService = new DialplanStoreService();

        $storeService->storeExtension('bootstrap', new BootstrapExtensionPreset());

        $res = Extension::query()->where('context', 'bootstrap');

        $this->assertTrue($res->count() > 0);
    }
}